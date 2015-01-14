<?php

class Company extends ActiveRecord {

  var $datatable = 'company';
  var $name_field = 'name';
  var $history_types = array(
      'Hours', 
      'Charges', 
      'Payments'
  );
  protected static $schema;
  protected static $schema_json = '{
    "fields": {
        "name": "text", 
        "alias": "text",
        "notes": "textarea", 
        "street": "text", 
        "street_2": "text", 
        "city": "text", 
        "state": "text", 
        "zip": "int", 
        "country": "text", 
        "preamp_id": "int", 
        "status": "text", 
        "bay_area": "bool", 
        "date_started": "date", 
        "date_ended": "date", 
        "billing_status": "text", 
        "org_type": "text", 
        "fax": "text"
    }, 
    "required": [
        "name", 
        "date_started", 
        "org_type", 
        "status"
    ], 
    "values": {
        "status": {
            "setup": "Setup", 
            "active": "Active", 
            "rEvent": "rEvent", 
            "closed": "Closed", 
            "free": "Low-Bagger", 
            "short": "Shortpants", 
            "off": "Uncontrolled Server", 
            "follow-up": "Follow Up"
        }, 
        "org_type": {
            "501c3": "501c3", 
            "union": "Union", 
            "political": "Political Campaign/Party", 
            "private": "Private Firm", 
            "pac527": "PAC/527", 
            "other": "other"
        }, 
        "billing_status": {
            "up-to-date": "Up To Date", 
            "overdue": "Overdue", 
            "collections": "Collections"
        }, 
        "country": {
            "usa": "USA", 
            "canada": "Canada", 
            "international": "International"
        }
    }
  }';

  function getProjects() {
    if(empty($this->projects)) {
      $this->projects= Project::getMany(array('company_id' => $this->id));
    }
    return $this->projects;  
  }

  function getSupportContracts($criteria = array()) {
    $criteria = array_merge(array('company_id' => $this->id), $criteria);
    $this->support_contracts = getMany('SupportContract', $criteria);
    return $this->support_contracts;
  }

  function getInvoices() {
    $this->invoices = getMany('Invoice', array('company_id' => $this->id, 'sort' => 'id DESC'));
    return $this->invoices;
  }

  function getNotes() {
    $this->notes = getMany('Note', array('company_id' => $this->id));
    return $this->notes;
  }

  function getPayments($override_criteria=array()) {
    $criteria = array_merge(array('company_id' => $this->id), $override_criteria);
    $this->payments = getMany('Payment', $criteria);
    return $this->payments;  
  }

  function getContacts() {
    if(empty($this->contacts)) {
      $this->contacts= getMany('Contact', array('company_id' => $this->id));
    }
    return $this->contacts;  
  }

  function getBillingContacts() {
    if(empty($this->billing_contacts)) {
      $this->billing_contacts= Contact::getMany(array('company_id' => $this->id, 'is_billing_contact' => 1));
    }
    return $this->billing_contacts;  
  }

  function getPrimaryContactName() {
    $primarycontacts = $this->getPrimaryContact(); 
    if(!empty($primarycontacts)) {
      $name = $this->getPrimaryContact()->getName();
    }
    return $name;
  }

  function getBillingContactName() {
    $billingcontacts = $this->getBillingContact(); 
    if(!empty($billingcontacts)) {
      $name = $this->getbillingContact()->getName();
    }
    return $name;
  }

  function getBillingPhone() {
    $billingcontacts = $this->getBillingContact(); 
    if(!empty($billingcontacts)) {
      $name = $this->getbillingContact()->getPhone();
    }
    return $name;
  }

  function getBillingEmailAddress() {
    $billingcontacts = $this->getBillingContacts();
    $primarycontacts = $this->getPrimaryContact(); 
    $email = '';
    if(!empty($billingcontacts)) {
      foreach($billingcontacts as $contact) $email .= $contact->getEmail() . ', ';
      $email = rtrim($email, ', ');
    } elseif(!empty($primarycontacts)) {
        $email = $this->getPrimaryContact()->getEmail();
    }

    if(TEST_MODE) {
      $email = BILLING_TEST_TO_EMAIL_ADDRESS;
    }

    return $email;
  }

  function getCharges($criteria = array()) {
    $criteria = array_merge(array('company_id' => $this->id), $criteria);
    $this->charges = Charge::getMany($criteria);
    return $this->charges;  
  }

  function getChargesByMonth($criteria = array()) {
    $criteria = array_merge(array('company_id' => $this->id), $criteria);
    $this->charges = Charge::getMany($criteria);
    $months = array();
    foreach($this->charges as $charge) {
      $month = Util::month_format($charge->getDate());
      if(empty($months[$month])) {
        $months[$month] = array(); 
      }
      array_push($months[$month], $charge); 
    }
    return $months; 
  }

  function getHours($criteria = array()) {
    return array_merge(
      $this->getProjectHours($criteria),
      $this->getSupportHours($criteria)
    );
  }

  function getProjectHours($criteria = array()) {
    $projects = $this->getProjects();
    $this->project_hours = array();
    if(!$projects) return $this->project_hours;
    foreach($projects as $project) {
      $hours = $project->getHours();
      if(!$hours) continue;
      $this->project_hours = array_merge($this->project_hours, $hours);
    }
    return $this->project_hours;
  }

  function getSupportHours($criteria = array()) {
    $contracts = $this->getSupportContracts();
    $this->support_hours = array();
    foreach($contracts as $contract) {
      $hours  = $contract->getHours($criteria);
      if(!$hours) continue;
      $this->support_hours = array_merge($this->support_hours, $hours);
    }
    return $this->support_hours;
  }

  function getFirstHour() {
    $first_hours = array();

    $projects = $this->getProjects();
    foreach($projects as $project) {
      $h = $project->getFirstHour();
      if(is_a($h, 'Hour')) {$first_hours[] = $h;}
    }
    $support_contracts = $this->getSupportContracts();
    foreach($support_contracts as $support_contract) {
      $h = $support_contract->getFirstHour();
      if(is_a($h, 'Hour')) {$first_hours[] = $h;}
    }
    if(!$first_hours) return;  
    usort($first_hours, array('Hour', 'compareByDate'));
    return $first_hours[0];
  }

  function getActiveMonths() {
    // get the earliest timestamp
    $first_hour = $this->getFirstHour();
    if(!$first_hour) return array();
    $earliest_ts = strtotime($first_hour->getDate());

    // add all months from the earliest to the current to the array
    $active_months = array();
    $ts = $earliest_ts;
    while($ts < time()) {
      $active_months[] = date('Y-m', $ts);
      $ts = strtotime('+1 month', $ts);
    }
    $active_months[] = date('Y-m', $ts);

    return $active_months;
  }

  function getPrimaryContact() {
    return Contact::getOne(array('company_id' => $this->id, 'is_primary_contact' => true));
  }

  function getBillingContact() {
    return Contact::getOne(array('company_id' => $this->id, 'is_billing_contact' => true));
  }

  function getTechnicalContact() {
    return Contact::getOne(array('company_id' => $this->id, 'is_technical_contact' => true));
  }
  
  function getStatus() {
    return $this->get('status');
  }

  function getPhone() {
    return $this->get('phone');
  }

  function getLastPaymentDate() {
    $payment = Payment::getOne(array('company_id' => $this->id, 'sort' => 'date DESC'));
    if($payment) {
      return $payment->getDate(); 
    }  
  }

  function calculateChargesTotal($date_range = array()) {
    $date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

    if(!$date_range) return 0;

    $charges = $this->getCharges(array('date_range' => $date_range));

    if(!$charges) return 0;

    $total = 0;
    foreach($charges as $charge) {
        $total += $charge->getAmount();
    }

    return $total;
  }

  function calculatePaymentsTotal($date_range = array()) {
    $date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

    if(!$date_range) return 0;

    $payments = $this->getPayments(array('date_range' => $date_range));

    if(!$payments) return 0;

    $total = 0;
    foreach($payments as $payment) {
      $total += $payment->getAmount();
    }

    return $total;
  }

  function calculateInvoiceTotal() {
    $invoices = $this->getInvoices();
    $total_invoices = 0;
    foreach ($invoices as $invoice) {
      $total_invoices += $invoice->getAmount();
    }
    return $total_invoices;
  }

  function calculateSupportTotal($date_range = array()) {
    $date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

    if(!$date_range) return 0;

    $contracts = $this->getSupportContracts();

    if(!$contracts) return 0;

    $total = 0;
    foreach($contracts as $c) {
      $amount = $c->calculateTotal($date_range);
      $total += $amount;
    }

    return $total;
  }

  function calculateSupportLineItems($active_months) {
    $data = array();
    $support_contracts = $this->getSupportContracts();
    if(!$support_contracts) return;

    foreach($active_months as $active_month) {
      $data[$active_month] = array();
      $monthly_total = 0;
      // support contracts
      $support_contracts_output = '';
      $support_contracts = $this->getSupportContracts();
      foreach($support_contracts as $support_contract) {
        if(!in_array($active_month,$support_contract->getActiveMonths())) {
          continue;
        };
        $monthly_rate = $support_contract->calculateMonthlyBaseRate($active_month);
        $hourly_rate = $support_contract->get('hourly_rate');

        // get all the hours
        $number_of_hours = $support_contract->getBillableHours(array(
          'date_range' => array(
            'start_date' => $active_month . '-01', // first day of the month
            'end_date' => $active_month . '-' . date('t', strtotime($active_month)) // last day of the month
          )
        ));
        $item = array();
        $item['name'] = $support_contract->get('domain_name');
        $item['hosting'] = $support_contract->calculateMonthlyBaseRate($active_month, false);
        $item['support_hours'] = $support_contract->get('support_hours');
        $item['support_hours_used'] = $number_of_hours;
        $item['support_cost'] = $support_contract->calculateMonthlyOverage($number_of_hours, $active_month, false);
        $data[$active_month][] = $item;
      }
    }
    return $data;
  }

  function calculateProjectLineItems($active_months) {
    $data = array();

    $projects = $this->getProjects();
    if(!$projects) return;

    foreach($active_months as $active_month) {
      $data[$active_month] = array();
      $monthly_total = 0;
      // projects 
      $project_output = '';
      $projects = $this->getProjects();
      foreach($projects as $project) {
        //if(!in_array($active_month,$project->getActiveMonths())) {
        //  continue;
        //};
        $hourly_rate = $project->getHourlyRate();
        // get all the hours
        $number_of_hours = $project->getBillableHours(array(
          'start_date' => $active_month.'-01', // first day of the month
          'end_date' => $active_month.'-'.date('t', strtotime($active_month)) // last day of the month
        ));
        $item = array();
        $item['name'] = $project->getName();
        $item['project_hours'] = $number_of_hours;
          $item['project_hours_rate'] = $hourly_rate;
          $item['project_total'] = $project->calculateTotal(array(
            'start_date' => $active_month.'-01', // first day of the month
            'end_date' => $active_month.'-'.date('t', strtotime($active_month)) // last day of the month
          ));
          $data[$active_month][] = $item;
        }

      }
      return $data;
  }

  function calculateChargeLineItems($active_months) {
    $data = array();
    $charges_by_month = $this->getChargesByMonth();
    foreach($active_months as $active_month) {
      if(empty($charges_by_month[$active_month])) {
        continue;
      }
      $data[$active_month] = array();
      foreach ($charges_by_month[$active_month] as $charge) {
        $line_item = array();
        $line_item['name'] = $charge->get('name');
        $line_item['date'] = $charge->getDate();
        $line_item['amount'] = $charge->getAmount();
        $data[$active_month][] = $line_item;
      }
    }
    return $data;
  }

  function calculateProjectsTotal($date_range = array()) {
    $date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

    if(!$date_range) return 0;

    $projects = $this->getProjects();

    if(!$projects) return 0;

    $total = 0;
    foreach($projects as $project) {
      $total += $project->calculateTotal($date_range);
    }  

    return $total;
  }

  function calculateCosts($date_range = array()) {
    if(empty($date_range['end_date'])) bail('$date_range["end_date"] required');

    $date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

    if(!$date_range) return 0;

    $support_total = $this->calculateSupportTotal($date_range);
    $project_total = $this->calculateProjectsTotal($date_range);
    $charges_total = $this->calculateChargesTotal($date_range);

    return $support_total + $project_total + $charges_total;
  }

  function getPreviousBalance() {
    //if(empty($this->previous_balance)) {
    return  $this->previous_balance = CompanyPreviousBalance::getOne(array('company_id' => $this->id, 'sort' => 'date DESC'));
    //}
    //return $this->previous_balance;
  }

  function getPreviousBalanceDate() {
    if($previous_balance = $this->getPreviousBalance()) return $previous_balance->getDate();
  }

  function getPreviousBalanceAmount() {
    if($previous_balance = $this->getPreviousBalance()) return $previous_balance->getAmount();
  }

  function calculateBalance($date_range = array()) {
    if(empty($date_range['end_date'])) bail('$date_range["end_date"] required');

    $date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

    if(!$date_range) return 0;

    $current_balance = $this->calculateCosts($date_range) - $this->calculatePaymentsTotal($date_range);
    $previous_balance = $this->getPreviousBalance();

    ### tests fail because of this! margot  
    if(empty($previous_balance)) return $current_balance;  
    $total_balance = ($current_balance + $previous_balance->getAmount());
    return $total_balance;
  }

  function updateDateRangeWithPreviousBalanceDate($date_range) {
    if(!isset($date_range['start_date'])) {
      $date_range['start_date'] = $this->getPreviousBalanceDate();
    } elseif($date_range['start_date'] < $this->getPreviousBalanceDate()) {
      $date_range['start_date'] = $this->getPreviousBalanceDate();
    }

    if(isset($date_range['end_date']) && $date_range['end_date'] <= $this->getPreviousBalanceDate()) {
      return false;
    }

    return $date_range;
  }

  function destroyAssociatedRecords() {
    if($this->getProjects()) {
      foreach($this->getProjects() as $project) {
        $project->destroyAssociatedRecords();
        $project->delete();
      }
    }
    if($this->getPayments()) {
      foreach($this->getPayments() as $payment) {
        $payment->destroyAssociatedRecords();
        $payment->delete();
      }
    }
    if($this->getCharges()) {
      foreach($this->getCharges() as $charge) {
        $charge->destroyAssociatedRecords();
        $charge->delete();
      }
    }
    if($this->getSupportContracts()) {
      foreach($this->getSupportContracts() as $contract) {
        $contract->destroyAssociatedRecords();
        $contract->delete();
      }
    }
    if($this->getContacts()) {
      foreach($this->getContacts() as $contact) {
        $contact->destroyAssociatedRecords();
        $contact->delete();
      }
    }
  }

  function getName() {
    $name = $this->get('name');
    $alias = $this->get('alias');
    if(isset($alias) && ($alias != '')) {
      $name = $alias . ' - ' . $name;
    }
    return $name;
  }

  function getDisplayName() {
    $name = $this->get('name');
    return $name;
  }
}

?>
