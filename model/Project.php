<?php

class Project extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "name";
	var $_class_name = "Project";
	var $_search_criteria_global = array( "modin = 54");
	var $hours;
	var $estimates;
	var $invoices;
	var $company;
	var $staff;
	
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"54"));
    }
    function getName(){
        return $this->getCompanyName().': '.$this->getData('name');
    }
	function getEstimates(){
		if(!$this->estimates){
			$finder = new Estimate();
			$this->estimates = $finder->find(array("project_id"=>$this->id));
		}
		return $this->estimates;	
	}
	function getInvoices(){
		if(!$this->invoices){
			$finder = new Invoice();
			$this->invoices = $finder->find(array("project_id"=>$this->id));
		}
		return $this->invoices;	
	}
	function getHours(){
		$estimates = $this->getEstimates();
		$this->hours = array();
		foreach($estimates as $estimate){
			$this->hours = array_merge( $this->hours,$estimate->getHours());
		}
		return $this->hours;
	}
	function getTotalHours(){
		$estimates = $this->getEstimates();
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getTotalHours();
		}
		return $hours;
	}
	function getBillableHours(){
		$estimates = $this->getEstimates();
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getBillableHours();
		}
		return $hours;
	}
	function getLowEstimate(){
		$estimates = $this->getEstimates();
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getLowEstimate();

		}
		return $hours;
	}
	function getHighEstimate(){
		$estimates = $this->getEstimates();
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getHighEstimate();
		}
		return $hours;
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
	function getContacts(){
		$company = $this->getCompany();
		return $company->getContacts();
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
		$this->legacyFieldName($data,'Company', "name" );
		$this->legacyFieldName($data,'custom1', "amp_url" );
		$this->legacyFieldName($data,'custom2', "design_date" );
		$this->legacyFieldName($data,'custom3', "desinger" );
		$this->legacyFieldName($data,'custom4', "launch_date" );
		$this->legacyFieldName($data,'custom5', "discovery_date" );
		$this->legacyFieldName($data,'custom6', "crm_notes" );
		$this->legacyFieldName($data,'custom7', "udm_notes" );
		$this->legacyFieldName($data,'custom8', "content_notes" );
		$this->legacyFieldName($data,'custom9', "custom_notes" );
		$this->legacyFieldName($data,'custom10', "training_notes" );
		$this->legacyFieldName($data,'custom11', "email_notes" );
		$this->legacyFieldName($data,'custom12', "domain_notes" );
		$this->legacyFieldName($data,'custom15', "contract_notes" );
		$this->legacyFieldName($data,'custom16', "other_notes" );
		$this->legacyFieldName($data,'custom17', "status" );
		$this->legacyFieldName($data,'custom18', "deposit" );
		$this->legacyFieldName($data,'custom19', "contract_url" );
		$this->legacyFieldName($data,'custom20', "deposit_date" );
		$this->legacyFieldName($data,'custom21', "other_contacts" );
		$this->legacyFieldName($data,'custom22', "basecamp_id" );
		$this->legacyFieldName($data,'custom23', "final_payment" );
		$this->legacyFieldName($data,'custom24', "final_payment_date" );
		$this->legacyFieldName($data,'custom26', "cost" );
		$this->legacyFieldName($data,'custom27', "priority" );
		$this->legacyFieldName($data,'custom28', "real_launch_date" );
		$this->legacyFieldName($data,'custom29', "real_design_date" );
		$this->legacyFieldName($data,'custom30', "hour_cap" );
		$this->legacyFieldName($data,'custom31', "staff_id" );
		$this->legacyFieldName($data,'custom32', "company_id" );
		$this->legacyFieldName($data,'custom33', "hourly_rate" );
		$this->legacyFieldName($data,'custom34', "hours_high" );
		$this->legacyFieldName($data,'custom35', "billing_status" );
		$this->legacyFieldName($data,'custom36', "main_payment" );
		$this->legacyFieldName($data,'custom37', "main_payment_date" );
		$this->legacyFieldName($data,'custom38', "billing_type" );
		$this->legacyFieldName($data,'custom39', "hours_low" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaName( $value ) {
		return $this->_makeCriteriaEquals( 'Company', $value );
	}
	function makeCriteriaAmpUrl( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaDesigDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaDesigner( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaLaunchDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaDiscoveryDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaCrmNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaUdmNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaContentNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom8', $value );
	}
	function makeCriteriaCstomNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom9', $value );
	}
	function makeCriteriaTrainingNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom10', $value );
	}
	function makeCriteriaEmailNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom11', $value );
	}
	function makeCriteriaDomainNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom12', $value );
	}
	function makeCriteriaContractNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom15', $value );
	}
	function makeCriteriaOtherNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom16', $value );
	}
	function makeCriteriaStatus( $value ) {
		return $this->_makeCriteriaEquals( 'custom17', $value );
	}
	function makeCriteriaDeposit( $value ) {
		return $this->_makeCriteriaEquals( 'custom18', $value );
	}
	function makeCriteriaContractUrl( $value ) {
		return $this->_makeCriteriaEquals( 'custom19', $value );
	}
	function makeCriteriaDepositDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom20', $value );
	}
	function makeCriteriaOtherContacts( $value ) {
		return $this->_makeCriteriaEquals( 'custom21', $value );
	}
	function makeCriteriaBasecampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom22', $value );
	}
	function makeCriteriaFinalPayment( $value ) {
		return $this->_makeCriteriaEquals( 'custom23', $value );
	}
	function makeCriteriaFinalPaymentDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom24', $value );
	}
	function makeCriteriaCost( $value ) {
		return $this->_makeCriteriaEquals( 'custom26', $value );
	}
	function makeCriteriaPriority( $value ) {
		return $this->_makeCriteriaEquals( 'custom27', $value );
	}
	function makeCriteriaRealLaunchDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom28', $value );
	}
	function makeCriteriaRealDesignDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom29', $value );
	}
	function makeCriteriaHourCap( $value ) {
		return $this->_makeCriteriaEquals( 'custom30', $value );
	}
	function makeCriteriaStaffId( $value ) {
		return $this->_makeCriteriaEquals( 'custom31', $value );
	}
	function makeCriteriaCompanyId( $value ) {
		return $this->_makeCriteriaEquals( 'custom32', $value );
	}
	function makeCriteriaHourlyRate( $value ) {
		return $this->_makeCriteriaEquals( 'custom33', $value );
	}
	function makeCriteriaHoursHigh( $value ) {
		return $this->_makeCriteriaEquals( 'custom34', $value );
	}
	function makeCriteriaBillingStatus( $value ) {
		return $this->_makeCriteriaEquals( 'custom35', $value );
	}
	function makeCriteriaMainPayment( $value ) {
		return $this->_makeCriteriaEquals( 'custom36', $value );
	}
	function makeCriteriaMainPaymentDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom37', $value );
	}
	function makeCriteriaBillingType( $value ) {
		return $this->_makeCriteriaEquals( 'custom38', $value );
	}
	function makeCriteriaHoursLow( $value ) {
		return $this->_makeCriteriaEquals( 'custom39', $value );
	}


}

?>
