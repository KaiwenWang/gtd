<?php

require_once( 'Gtd_Data_Item.php');

class Hour extends Gtd_Data_Item {

	var $datatable = "userdata";
	var $name_field = "description";
	var $_class_name = "Hour";
	var $hours;
	var $staff;
	var $_search_criteria_global = array( "modin = 62");
	
	function Hour ( $id = null ) {
    	$this->__construct( $id );
    }
    function __construct( $id = null){
        $dbcon = getDbcon();
        parent::__construct( $dbcon, $id);
        $this->mergeData(array("modin"=>"62"));
    }
    function getName(){
        return $this->getData('description');
    }
	function getHours(){
		if (!$this->hours){
			$hours = $this->getData('hours');
			if (!$hours) $hours = 0;
			$this->hours = $hours;
			return $hours;
		}
	}
	function getDiscount(){
		$hours = $this->getData('discount');
		if (!$hours) $hours = 0;
		return $hours;
	}
	function getStaff(){
	   if (!$this->staff){
	       $this->staff = new Staff( $this->getData('staff_id'));
        }
        return $this->staff;
	}
    function getStaffName(){
        $staff = $this->getStaff();
        return $staff->getName();
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom2', "estimate_id" );
		$this->legacyFieldName($data,'custom3', "description" );
		$this->legacyFieldName($data,'custom4', "staff_id" );
		$this->legacyFieldName($data,'custom5', "date" );
		$this->legacyFieldName($data,'custom6', "hours" );
		$this->legacyFieldName($data,'custom7', "support_contract_id" );
		$this->legacyFieldName($data,'custom10', "discount" );
		$this->legacyFieldName($data,'custom11', "basecamp_id" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaEstimateId( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaDescription( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaStaffId( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaHours( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaSupportContractId( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaDiscount( $value ) {
		return $this->_makeCriteriaEquals( 'custom10', $value );
	}
	function makeCriteriaBasecampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom11', $value );
	}
}
?>
