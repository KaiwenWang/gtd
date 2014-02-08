<?php

class Hour extends ActiveRecord {

  var $datatable = 'hour';
  var $name_field = 'description';
  protected static $schema;
  protected static $schema_json = '{
    "fields": {
        "estimate_id": "Estimate",
        "support_contract_id": "SupportContract",
        "staff_id": "Staff",
        "pair_id": "Staff",
        "pair_name": "text",
        "pair_hour_id": "Hour",
        "description": "text",
        "date": "date",
        "hours": "float",
        "discount": "float",
        "basecamp_id": "int"
    },
    "required": [
        "staff_id",
        [
            "estimate_id",
            "support_contract_id"
        ],
        "description",
        "date"
    ]
  }';

  function __construct($id = null) {
    parent::__construct($id);
  }

  static function compareByDate($a, $b) {
    return strcmp($a->getDate(), $b->getDate());
  }

  function updateOrCreateWithPair() {
    $this->save();

    if(!$this->get('pair_id')) {
      return;
    }

    $pair = $this->getPairHour();
    $pair->set(array(
      'hours' => $this->get('hours'),
      'staff_id' => $this->get('pair_id'),
      'pair_id' => $this->get('staff_id'),
      'pair_name' => $this->getStaffName(),
      'pair_hour_id' => $this->id,
      'estimate_id' => $this->get('estimate_id'),
      'support_contract_id' => $this->get('support_contract_id'),
      'description' => $this->get('description'),
      'date' => $this->get('date'),
      'discount' => $this->get('discount')
    ));
    $pair->save();

    $this->set(array('pair_hour_id' => $pair->id,'pair_name' => $pair->getStaffName()));
    $this->save();
  }

  function is_pair() {
    if($this->get('pair_hour_id')) return true;
  }

  function getPairName() {
    return $this->getStaffName() . ' and ' . $this->get('pair_name');
  }

  function getPairHour() {
    $this->pair_hour = new Hour($this->get('pair_hour_id'));
    return $this->pair_hour;
  }

  function discountIfInternalProject() {
    $project = $this->getProject();
    if($project && $project->is_internal()) {
      $this->set(array('discount' => $this->getHours()));
    }
  }

  function save() {
    $this->discountIfInternalProject();  
    parent::save();
  }

  function getName() {
    return $this->get('description');
  }

  function getDate() {
    return $this->get('date');
  }

  function getHours() {
    $hours = $this->get('hours');
    if(!$hours) $hours = 0;
    return $hours;
  }

  function getDiscount() {
    $hours = $this->get('discount');
    if(!$hours) $hours = 0;
    return $hours;
  }

  function getHourlyRate() {
    // really you want to ask a project about this.  use this ifyou need itemized costs in a display.
    if($this->is_project_hour()) {
      $rate = $this->getProject()->getHourlyRate();
    } else {
      $rate = $this->getSupportContract()->getHourlyRate();
    }
    return $rate;
  }

  function getBillableAmount() {
    // really you want to ask a project about this.  use this ifyou need itemized costs in a display.
    return $this->getCost($this->getHourlyRate());
  }

  function getCost($hourly_rate) {
    // really you want to ask a project about this.  use this ifyou need itemized costs in a display.
    return $this->getBillableHours() * $hourly_rate;
  }

  function getBillableHours() {
    return $this->getHours() - $this->getDiscount();    
  }

  function getStaff() {
    if(!isset($this->staff)) {
      $this->staff = new Staff($this->get('staff_id'));
    }
    return $this->staff;
  }

  function getPair() {
    if(!isset($this->staff)) {
      $this->staff = new Staff($this->get('pair_id'));
    }
    return $this->staff;
  }

  function getType() {
    if($this->is_project_hour()) return 'project';
    else return 'support';
  }

  function getSupportContract() {
    if(!$this->get('support_contract_id')) { 
      die('Invalid Hour');
    }
    if(!isset($this->support_contract)) {
      $this->support_contract = new SupportContract($this->get('support_contract_id'));
    }
    return $this->support_contract;
  }

  function getEstimate() {
    if(!$this->is_project_hour()) return;
    if(!isset($this->estimate)) {
      $this->estimate = new Estimate($this->get('estimate_id'));
    }
    return $this->estimate;
  }

  function getProject() {
    if(!$this->is_project_hour()) return;
    if(!isset($this->project)) {
      $this->project = $this->getEstimate()->getProject();
    }
    return $this->project;
  }

  function getStaffName() {
    $staff = $this->getStaff();
    return $staff->getName();
  }

  function getCompany() {
    if($this->is_project_hour()) {
      return $this->getProject()->getCompany();
    } elseif($this->is_support_contract_hour()) {
      return $this->getSupportContract()->getCompany();
    } else {
      print('<pre>Hour #' . $this->id . ' has neither an estimate nor support contract number. Please rectify.</pre>'); 
    }
  }

  function getCompanyName() {
    return $this->getCompany()->getName();
  }

  function is_valid() {}

  function is_project_hour() {
    if($this->get('estimate_id')) return true;
  }

  function is_support_contract_hour() {
    if($this->get('support_contract_id')) return true;
  }

  function to_spokes() {
    $date = Util::start_of_month($this->getDate());
    $javascript_timestamp = $date*1000;
    return(array('date' => $javascript_timestamp, 'value' => $this->getBillableHours()));
  }

  function getHistoryDate() {
    return $this->getDate();
  }

  function getHistoryName() {
    if($this->is_project_hour()) {
      $name = $this->getProject()->getShortName();
    } else {
      $name = 'Support';
    }
    return $name.': '.$this->getName();
  }

  function getHistoryDescription() {
    return $this->getBillableHours().' hours at '.$this->getHourlyRate();
  }

  function getHistoryAmount() {
    return $this->getBillableAmount();
  }

  function makeCriteriaHourSearch($data) {
    return $this->makeCriteriaDateRange($data);
  }

  function makeCriteriaSupportContract($values) {
    return $this->_makeCriteriaMultiple('support_contract_id', $values);
  }

  function makeCriteriaEstimate($values) {
    if(!empty($values)) {
      return $this->_makeCriteriaMultiple('estimate_id', $values);
    }
  }

  function makeCriteriaProject($values) {
    $estimates = array();
    foreach($values as $value) {
      $project_estimates =  Estimate::getMany(array('project' => $value));
      if(!empty($project_estimates)) {
        $estimates = array_merge($estimates, $project_estimates);
      }
    }  
    return $this->makeCriteriaEstimate(array_map(function($item) {return $item->id;}, $estimates)); 
  }

  function makeCriteriaCompanyId($value) {
    return $this->makeCriteriaCompany($value);
  }

  function makeCriteriaCompany($value) {
    $sql = array();

    $projects = Project::getMany(array('company_id' => $value));
    if($projects) {
      $project_ids = array();
      $sql[] = $this->makeCriteriaProject(array_map(function($item) {return $item->id;}, $projects));
    }

    $support_contracts = SupportContract::getMany(array('company_id' => $value));
    if($support_contracts) {
      $sql[] = $this->makeCriteriaSupportContract(array_map(function($item) {return $item->id;}, $support_contracts));
    }

    return '(' . implode(' or ', $sql) . ') ';
  }

}

?>
