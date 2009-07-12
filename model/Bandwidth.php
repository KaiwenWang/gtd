<?php

class Bandwidth extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "custom2";
	var $_class_name = "Bandwidth";
    var $_search_criteria_global = array( "modin = 70");

    function __construct(  $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"70"));
    }
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom1', "support_contract_id" );
		$this->legacyFieldName($data,'custom2', "gigs_over" );
		$this->legacyFieldName($data,'custom3', "date" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaSupportContractId( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaGigsOver( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
}
?>
