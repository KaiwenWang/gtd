<?php

class Invoice extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "custom10";
	var $_class_name = "Invoice";
	var $_search_criteria_global = array( "modin = 72");
	var $invoice_items;
	var $company;
    protected static $schema_json = "{	
			'fields'   : {	
							'support_contract_id'  :  'SupportContract',
							'project_id'	:  'Project',
							'type'  		:  'text',
							'start_date'  	:  'date',
							'end_date'  	:  'date',
							'pdf'  			:  'text',
							'url'  			:  'text',
							'html'  		:  'textarea',
							'sent_date'  	:  'date',
							'date'  		:  'date',
							'amount'  		:  'float'
						},
			'required' : {
							
						}
			}";	
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"72"));
    }
	function getInvoiceItems(){
		if(!$this->invoice_items){
			$finder = new InvoiceItem();
			$this->invoice_items= $finder->find(array("invoice_id"=>$this->id));
		}
		return $this->invoice_items;	
	}
	function getAmount(){
		if ($this->getData('amount')) return $this->getData('amount');
		$items = $this->getInvoiceItems();
		$total = 0;
		foreach ($items as $item){
			$total += $item->getAmount();
		}
		return $total;
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
		$this->legacyFieldName($data,'custom1', "support_contract_id" );
		$this->legacyFieldName($data,'custom2', "project_id" );
		$this->legacyFieldName($data,'custom3', "type" );
		$this->legacyFieldName($data,'custom4', "start_date" );
		$this->legacyFieldName($data,'custom5', "end_date" );
		$this->legacyFieldName($data,'custom6', "pdf" );
		$this->legacyFieldName($data,'custom7', "url" );
		$this->legacyFieldName($data,'custom8', "html" );
		$this->legacyFieldName($data,'custom9', "sent_date" );
		$this->legacyFieldName($data,'custom10', "date" );
		$this->legacyFieldName($data,'custom11', "amount" );	
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaSupportContractId( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaProjectId( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaType( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaStartDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaEndDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaPdf( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaUrl( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaHtml( $value ) {
		return $this->_makeCriteriaEquals( 'custom8', $value );
	}
	function makeCriteriaSentDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom9', $value );
	}
	function makeCriteriaDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom10', $value );
	}
	function makeCriteriaAmount( $value ) {
		return $this->_makeCriteriaEquals( 'custom11', $value );
	}
	


}

?>
