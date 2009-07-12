<?php

class Company extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "Company";
	var $_class_name = "Company";

	var $projects;
	var $support_contracts;
	var $invoices;
	var $payments;
	var $contacts;
	var $billing_contacts;
    var $_search_criteria_global = array( "modin = 60");
    
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"60"));
    }
	function getProjects(){
		if(!$this->projects){
			$finder = new Project();
			$this->projects= $finder->find(array("company_id"=>$this->id));
		}
		return $this->projects;	
	}
	function getSupportContracts(){
		if(!$this->support_contracts){
			$finder = new SupportContract();
			$this->support_contracts = $finder->find(array("company_id"=>$this->id));
		}
		return $this->support_contracts;
	}
	function getInvoices(){
		if (!$this->invoices){
			$contracts = $this->getSupportContracts();
			$projects = $this->getProjects();
			$invoices = array();
			foreach($contracts as $contract){
				if($contract->getInvoices()) $invoices = array_merge($invoices, $contract->getInvoices());
			}
			foreach($projects as $project){
				if($project->getInvoices()) $invoices = array_merge($invoices,$project->getInvoices());
			}
			$this->invoices = $invoices;
		}
		return $this->invoices;
	}
	function getPayments(){
		if(!$this->payments){
			$finder = new Payment();
			$this->payments= $finder->find(array("company_id"=>$this->id));
		}
		return $this->payments;	
	}
	function getTotalPayments(){
		$payments = $this->getPayments();
		$total_payments = 0;
		foreach ($payments as $payment){
			$total_payments += $payment->getAmount();
		}
		return $total_payments;
	}
	function getTotalInvoices(){
		$invoices = $this->getInvoices();
		$total_invoices = 0;
		foreach ($invoices as $invoice){
			$total_invoices += $invoice->getAmount();
		}
		return $total_invoices;
	}
	function getBalance(){
		return $this->getTotalInvoices() - $this->getTotalPayments();
	}
	function getContacts(){
		if(!$this->contacts){
			$finder = new Contact();
			$this->contacts= $finder->find(array("company_id"=>$this->id));
		}
		return $this->contacts;	
	}
	function getBillingContacts(){
		if(!$this->billing_contacts){
			$finder = new Contact();
			$this->billing_contacts= $finder->find(array("company_id"=>$this->id,"billable"=>1));
		}
		return $this->billing_contacts;	
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'Company', "name" );
		$this->legacyFieldName($data,'Notes', "notes" );
		$this->legacyFieldName($data,'Street', "street" );
		$this->legacyFieldName($data,'Street_2', "street_2" );
		$this->legacyFieldName($data,'City', "city" );
		$this->legacyFieldName($data,'State', "state" );
		$this->legacyFieldName($data,'Zip', "zip" );
		$this->legacyFieldName($data,'Phone', "phone" );
		$this->legacyFieldName($data,'Cell_Phone', "other_phone" );
		$this->legacyFieldName($data,'Work_Phone', "billing_phone" );
		$this->legacyFieldName($data,'custom6', "stasi_id" );
		$this->legacyFieldName($data,'custom7', "preamp_id" );
		$this->legacyFieldName($data,'custom8', "status" );
		$this->legacyFieldName($data,'custom9', "product" );
		$this->legacyFieldName($data,'custom10', "bay_area" );
		$this->legacyFieldName($data,'custom11', "balence" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaCompany( $value ) {
		return $this->_makeCriteriaEquals( 'Company', $value );
	}
	function makeCriteriaNotes( $value ) {
		return $this->_makeCriteriaEquals( 'Notes', $value );
	}
	function makeCriteriaStreet( $value ) {
		return $this->_makeCriteriaEquals( 'Street', $value );
	}
	function makeCriteriaStreet2( $value ) {
		return $this->_makeCriteriaEquals( 'Street_2', $value );
	}
	function makeCriteriaCity( $value ) {
		return $this->_makeCriteriaEquals( 'City', $value );
	}
	function makeCriteriaState( $value ) {
		return $this->_makeCriteriaEquals( 'State', $value );
	}
	function makeCriteriaZip( $value ) {
		return $this->_makeCriteriaEquals( 'Zip', $value );
	}
	function makeCriteriaPhone( $value ) {
		return $this->_makeCriteriaEquals( 'Phone', $value );
	}
	function makeCriteriaOtherPhone( $value ) {
		return $this->_makeCriteriaEquals( 'Cell_Phone', $value );
	}
	function makeCriteriaBillingPhone( $value ) {
		return $this->_makeCriteriaEquals( 'Work_Phone', $value );
	}
	function makeCriteriaStasiId( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaPreampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaStatus( $value ) {
		return $this->_makeCriteriaEquals( 'custom8', $value );
	}
	function makeCriteriaProduct( $value ) {
		return $this->_makeCriteriaEquals( 'custom9', $value );
	}
	function makeCriteriaBayArea( $value ) {
		return $this->_makeCriteriaEquals( 'custom10', $value );
	}
	function makeCriteriaBalence( $value ) {
		return $this->_makeCriteriaEquals( 'custom11', $value );
	}
}

?>
