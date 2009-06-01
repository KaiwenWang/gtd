<?php

class AddOn extends  ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "custom2";
	var $_class_name = "AddOn";
    var $_search_criteria_global = array( "modin = 71");

	function AddOn ( $id = null ) {
    	$this->__construct( $id );
    }
    function __construct( $id = null){
        $dbcon = getDbcon();
        parent::__construct( $dbcon, $id);
        $this->mergeData(array("modin"=>"71"));
    }

    function getAddOns(){
        if (!$this->addons){
            $addons = $this->getData('amount');
            if (!$addons) $addons = 0;
            $this->addons= $addons;
            return $addons;
        }
    }

    function getTotalAddOns(){
        $add_ons = $this->getAddOns();
        $total_add_ons = 0;
        foreach ($hours as $hour){
            $total_add_ons += $add_ons->getAddOns();
        }
        return $total_add_ons;
    }	
	



	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom1', "support_contract_id" );
		$this->legacyFieldName($data,'custom2', "name" );
		$this->legacyFieldName($data,'custom3', "amount" );
		$this->legacyFieldName($data,'custom4', "description" );
		$this->legacyFieldName($data,'custom5', "date" );
		$this->legacyFieldName($data,'custom6', "invoice_id" );
	
	
	

	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaSupportContractId( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaName( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaAmount( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaDescription( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaInvoiceId( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	


}

?>
