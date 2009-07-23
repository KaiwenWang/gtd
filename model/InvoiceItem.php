<?php

class InvoiceItem extends ActiveRecord {

	var $datatable = "userdata";
	var $_class_name = "InvoiceItem";
	var $_search_criteria_global = array( "modin = 73");

	var $name_field = "custom2";
    protected static $schema_json = "{	
			'fields'   : {	
							'invoice_id'  :  'Invoice',
							'name'  :  'text',
							'description'  :  'textarea',
							'amount'  :  'float',
							'date'  :  'date',
							'type'  :  'text'
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"73"));
    }
	function getAmount(){
		return $this->getData('amount');
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom1', "invoice_id" );
		$this->legacyFieldName($data,'custom2', "name" );
		$this->legacyFieldName($data,'custom3', "description" );
		$this->legacyFieldName($data,'custom4', "amount" );
		$this->legacyFieldName($data,'custom5', "date" );
		$this->legacyFieldName($data,'custom6', "type" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaInvoiceId( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaName( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaDescription( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaAmount( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaType( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}


}

?>
