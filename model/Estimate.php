<?php

class Estimate extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "description";
	var $_class_name = "Estimate";
	var $hours;
    var $_search_criteria_global = array( "modin = 63");

    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"63"));
    }
	function getHours(){
		if(!$this->hours){
			$finder = new Hour();
			$this->hours = $finder->find(array("estimate_id"=>$this->id));
		}
		return $this->hours;	
	}
	function getTotalHours(){
		$hours = $this->getHours();
		$total_hours = 0;
		foreach ($hours as $hour){
			$total_hours += $hour->getHours();
		}
		return $total_hours;
	}
	function getBillableHours(){
		$hours = $this->getHours();
		$billable_hours = 0;
		foreach ($hours as $hour){
			$billable_hours += $hour->getBillableHours();
		}
		return $billable_hours;
	}
	function getLowEstimate(){
		return $this->getData('low_hours');
	}
	function getHighEstimate(){
		return $this->getData('high_hours');
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom1', "project_id" );
		$this->legacyFieldName($data,'custom2', "description" );
		$this->legacyFieldName($data,'custom3', "high_hours" );
		$this->legacyFieldName($data,'custom4', "due_date" );
		$this->legacyFieldName($data,'custom5', "completed" );
		$this->legacyFieldName($data,'custom6', "notes" );
		$this->legacyFieldName($data,'custom7', "low_hours" );
		$this->legacyFieldName($data,'custom8', "basecamp_id" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaProjectId( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaDescription( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaHighHours( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaDueDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaCompleted( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaLowHours( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaBasecampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom8', $value );
	}
}

?>
