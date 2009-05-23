<?php

require_once( 'Gtd_Data_Item.php');

class Bandwidth extends Gtd_Data_Item {

	var $datatable = "userdata";
	var $name_field = "custom2";
	var $_class_name = "Bandwidth";
    var $_search_criteria_global = array( "modin = 70");

	function Bandwidth ( $id = null ) {
    	$this->__construct( $id );
    }
    function __construct(  $id = null){
        $dbcon = getDbcon();
        parent::__construct( $dbcon, $id);
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
