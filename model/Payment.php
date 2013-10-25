<?php
class Payment extends ActiveRecord {

  var $datatable = "payment";
  var $name_field = "amount";

    protected static $schema;
    protected static $schema_json = '{  
      "fields"   : {  
              "date"    :  "date",
              "amount"    :  "float",
              "payment_type" :  "text",
              "preamp_id" :  "int",
              "preamp_client_id"  :  "int",
              "product"    :  "text",
              "invoice_id":  "int",
              "company_id":  "Company",
              "notes"    :  "textarea",
                            "check_number" : "text"
            },
      "required" : [
      ],
      "values"   : {
        "payment_type":{"check":"Check","paypal":"Paypal","direct":"Direct Deposit","cash":"Cash","credit":"Credit","write_off":"Write Off"}
            },
      }';

    function getAmount(){
            return $this->get('amount');
    }
    function getType(){
            return $this->get('payment_type');
    }
    function getCheckNumber(){
            return $this->get('check_number');
    }
    function getDate() {
        return $this->get( 'date' );
    }
  function getNotes(){
    return $this->get('notes');
  }
  function getInvoiceId() {
    return $this->get('invoice_id');
  }
    function getCompany(){
            if(empty($this->company)){
                    $this->company = new Company( $this->get('company_id'));
            }
            return $this->company;  
    }
    function getCompanyName(){
        $company = $this->getCompany();
        return $company->getName();
  }
    function _sort_default( &$item_set ){
        return $this->sort( $item_set, 'date', 'desc');
    }
  function getHistoryName() {
    if( $this->getType() == 'check') {
      return 'Payment: Check  #'. $this->getCheckNumber();
    } else {
      return 'Payment: '. ucwords($this->getType());   
    }    
  }
  function getHistoryDate(){
    return $this->getDate();
  }
  function getHistoryDescription(){
    return $this->getNotes();
  }
  function getHistoryAmount(){
    return $this->getAmount();
  }
  function getBillingEmailAddress(){
    return $this->getCompany()->getBillingEmailAddress();
  }
  function getBillingName(){
    return $this->getCompany()->getBillingContactName();
  }
  
  function to_spokes(){
    $date = Util::start_of_month($this->getDate());
    $javascript_timestamp = $date*1000;
    return( array( 'date'=>$javascript_timestamp, 'value'=>$this->getAmount()));
  }
  
  function sendEmail() {
        if(!isset($this->id)) bail("must haz id to do that!");
    
    $d = new PHP5_Accessor();

        $d->payment = $this;
    $d->company = $this->getCompany();
    
    $r = getRenderer();
    $htmlcontent = $r->view('paymentReceiptEmail', $d);
    $plaincontent = $r->view('paymentReceiptEmailPlain', $d);

    $email_address = $this->getBillingEmailAddress();
    $subject = 'Radical Designs Payment Receipt ' . Util::pretty_date($this->get('date')); 

    $boundary = "nextPart";
    $headers = 'From: ' . BILLING_EMAIL_ADDRESS."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary = $boundary\r\n\r\n";
    $headers .= "This is a MIME encoded message.\r\n\r\n"; 
    $headers .= "\r\n--$boundary\r\n"; // beginning \n added to separate previous content
    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
    $headers .= $plaincontent;
    $headers .= "\r\n\r\n--$boundary\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= $htmlcontent;

    $email_sent = mail($email_address,$subject,"", $headers);

    if( $email_sent ){
      Render::msg('Email Sent');
    } else {
      Render::msg('Email Failed To Send','bad');
    }
  }
}
