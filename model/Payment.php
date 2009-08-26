<?php

class Payment extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "custom2";
	var $_class_name = "Payment";
	var $company;
	var $_search_criteria_global = array( "modin = 69");
    protected static $schema_json = "{	
			'fields'   : {	
							'date'  	:  'date',
							'amount'  	:  'float',
							'type'		:  'text',
							'preamp_id' :  'int',
							'preamp_client_id'  :  'int',
							'product'  	:  'text',
							'invoice_id':  'Invoice',
							'company_id':  'Company',
							'notes'  	:  'textarea'
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"69"));
    }
	function getAmount(){
		return $this->getData('amount');
	}
	function getCompany(){
		if(!$this->company){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}
    function getCompanyName(){
        $company = $this->getCompany();
        return $company->getName();
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom1', "date" );
		$this->legacyFieldName($data,'custom2', "amount" );
		$this->legacyFieldName($data,'custom3', "type" );
		$this->legacyFieldName($data,'custom4', "preamp_id" );
		$this->legacyFieldName($data,'custom5', "preamp_client_id" );
		$this->legacyFieldName($data,'custom6', "product" );
		$this->legacyFieldName($data,'custom7', "invoice_id" );
		$this->legacyFieldName($data,'Company', "company_id" );
		$this->legacyFieldName($data,'Notes', "notes" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaAmount( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaType( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaPreampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaPreampClientId( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaProduct( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaInvoiceId( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaCompanyId( $value ) {
		return $this->_makeCriteriaEquals( 'Company', $value );
	}
	function makeCriteriaNotes( $value ) {
		return $this->_makeCriteriaEquals( 'Notes', $value );
	}
	
	


}

?>
