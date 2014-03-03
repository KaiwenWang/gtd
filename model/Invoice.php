<?php

class Invoice extends ActiveRecord {

    var $datatable = 'invoice';
    var $name_field = 'id';
    protected static $schema;
    protected static $schema_json = '{
      "fields": {
        "company_id": "Company", 
        "batch_id": "InvoiceBatch", 
        "type": "text", 
        "start_date": "date", 
        "end_date": "date", 
        "pdf": "text", 
        "sent_date": "date", 
        "status": "text", 
        "previous_balance": "float", 
        "new_costs": "float", 
        "amount_due": "float", 
        "new_payments": "float", 
        "details": "textarea", 
        "additional_recipients": "textarea", 
        "date": "date", 
        "payment_status": "text"
      }, 
      "required": [], 
      "values": {
        "status": {
            "not_sent": "Pending", 
            "sent": "Sent", 
            "failed": "Failed to Send"
        }, 
        "type": {
            "stand_alone": "Stand Alone", 
            "dated": "Date Range"
        }, 
        "payment_status": {
            "outstanding": "Outstanding", 
            "paid": "Paid", 
            "cancelled": "Cancelled", 
            "null": "N/A"
        }
      }
  }';  

  function __construct($id = null) {
    parent::__construct($id);
  }

  function getName() {
    return $this->getCompanyName() . ' ' . $this->getStartDate() . ' ' . $this->getEndDate();
  }

  function getStatus() {
    $status = $this->getData('payment_status');
    if($status == null) {
      return 'N/A';
    }
    return ucwords($status);
  }

  function getType() {
    return $this->getData('type');
  }

  function isValid() {
    $valid = true;

    if(!$this->getData('company_id')) {
      $this->errors[] = 'company_id must be set.';
      $valid = false;
    }
    if(!$this->getData('amount_due')) {
      if(!$this->getData('start_date')) {
        $this->errors[] = 'start_date must be set.';
        $valid = false;
      }
      if(!$this->getData('end_date')) {
        $this->errors[] =  'end_date must be set.';
      }  
    }

    if($valid && parent::isValid()) return true;
  }
  function getStartDate() {
    return  date('M jS, Y', strtotime($this->get('start_date')));
  }
  function getEndDate() {
    return date('M jS, Y', strtotime($this->get('end_date')));
  }

  function getDate() {
    return date('M jS, Y', strtotime($this->get('date')));
  }

  function getInvoiceItems() {
    if(!$this->invoice_items) {
      $finder = new InvoiceItem();
      $this->invoice_items= $finder->find(array('invoice_id' => $this->id));
    }
    return $this->invoice_items;  
  }
  function getNewPaymentsTotal() {
    return $this->get('new_payments');
  }
  function getNewCosts() {
    return $this->get('new_costs');
  }
  function getAmountDue() {
    return $this->get('amount_due');
  }  
  function getPreviousBalance() {
    return $this->get('previous_balance');
  }
  function getCompany() {
    if(empty($this->company)) $this->company = new Company($this->getData('company_id'));
    return $this->company;  
  }
  function getBatch() {
    if($batch_id = $this->get('batch_id')) return new InvoiceBatch($batch_id);
  }
  function getCompanyName() {
    return $this->getCompany()->getName();
  }

  function getAdditionalRecipients() {
    if($additional_recipients = $this->get('additional_recipients')) {
      return ', ' . $this->get('additional_recipients');
    } else {
      return null;
    }
  }

  function setNewAsOutstanding() {
    $this->set(array('payment_status' => 'outstanding'));
  }

  function execute() {
    if(!$this->isValid()) bail($this->errors);
    if(!$this->get('amount_due')) {  
      $this->setFromCompany( $this->getCompany(), 
      array(
        'start_date' => $this->get('start_date'), 
        'end_date'   => $this->get('end_date')
      ));
    } else {
        $this->setFromAmountDue( $this->getCompany(), $this->get('amount_due'));
    }
  }

  function setFromAmountDue($company, $amount_due) {
    if(!is_a($company, 'Company')) bail('setFromAmountDue requires first param to be a Company object.');

    $this->company = $company;

    $this->set(array(
      'company_id' => $this->company->id, 
      'type' => 'stand_alone', 
      'amount_due' => $amount_due
    ));
  }

  function setFromCompany($company, $date_range) {
    if(!is_a($company, 'Company')) bail('setFromCompany requires first param to be a Company object');

    $this->company = $company;

    $previous_balance_date = array('end_date' => $date_range['start_date']);
    $amount_due_date = array('end_date' => $date_range['end_date']);

    die($previous_balance_date);
    $previous_balance = $this->company->calculateBalance($previous_balance_date);
    $new_costs = $this->company->calculateCosts($date_range);
    $new_payments = $this->company->calculatePaymentsTotal($date_range);
    $amount_due = $this->company->calculateBalance($amount_due_date);

    $this->set(array(
      'company_id' => $this->company->id, 
      'type' => 'dated', 
      'start_date' => $date_range['start_date'], 
      'end_date' => $date_range['end_date'], 
      'previous_balance' => $previous_balance, 
      'new_costs' => $new_costs, 
      'new_payments' => $new_payments, 
      'amount_due' => $amount_due
    ));
  }

  function getBillingEmailAddress() {
    return $this->getCompany()->getBillingEmailAddress();
  }

  static function createFromCompany($company, $batch) {
    $i = new Invoice();
    $date_range = array(
      'start_date' => $batch->getStartDate(), 
      'end_date' => $batch->getEndDate(), 
    );
    $i->setFromCompany($company, $date_range);
    if($batch) $i->set(array('batch_id' => $batch->id));
    $i->setNewAsOutstanding();
    $i->save();
    return $i;
  } 

  function sendEmail() {
    if(!isset($this->id)) bail("must haz id to do that!");
    //trigger_error('Statement #'.$this->id.' preparing to send email');

    $d = new PHP5_Accessor();

    $d->invoice = $this;
    $d->company = $this->getCompany();

    $r = getRenderer();
    $htmlcontent = $r->view('invoiceEmail', $d);
    $plaincontent = $r->view('invoiceEmailPlain', $d);

    $email_address = $this->getBillingEmailAddress() . $this->getAdditionalRecipients();
    if($this->getType() == 'dated') {
      $subject = 'Radical Designs Statement ' . Util::pretty_date($this->get('end_date')); 
    } else {
      $subject = 'Radical Designs Statement ' . Util::pretty_date($this->get('date')); 
    }
    $boundary = "nextPart";
    $headers = 'From: ' . BILLING_EMAIL_ADDRESS."\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative; boundary = $boundary\n\n";
    $headers .= "This is a MIME encoded message.\n\n"; 
    $headers .= "\n--$boundary\n"; // beginning \n added to separate previous content
    $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
    $headers .= $plaincontent;
    $headers .= "\n\n--$boundary\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= $htmlcontent;

    $email_sent = mail($email_address, $subject, "", $headers);

    if($email_sent) {
      $this->set(array('sent_date' => Util::date_format(), 'status' => 'sent'));
      Render::msg('Email Sent');
    } else {
      $this->set(array('status' => 'failed'));
      Render::msg('Email Failed To Send', 'bad');
    }

    $this->save();

  }

}

?>
