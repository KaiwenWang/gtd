<?php

require_once( 'Gtd_Data_Item.php');

class SupportContract extends Gtd_Data_Item {

	var $datatable = "userdata";
	var $name_field = "domain_name";
	var $_class_name = "SupportContract";
	var $_search_criteria_global = array( "modin = 67");
	var $invoices;
	var $hours;
	var $add_ons;
	var $product_instances;
	var $bandwidths;
	function SupportContract ( $id = null ) {
    	$this->__construct( $id );
    }
    function __construct( $id = null){
        $dbcon = getDbcon();
        parent::__construct( $dbcon, $id);
        $this->mergeData(array("modin"=>"67"));
    }
    function getName(){
        return $this->getCompanyName().': '.$this->getData('domain_name');
    }
	function getInvoices(){
		if(!$this->invoices){
			$finder = new Invoice();
			$this->invoices = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->invoices;	
	}
    function getHours(){
        if(!$this->hours){
            $finder = new Hour();
            $this->hours = $finder->find(array("support_contract_id"=>$this->id));
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
            $billable_hours += $hour->getHours();
            $billable_hours -= $hour->getDiscount();
        }
        return $billable_hours;
    }
	function getProductInstances(){
		if(!$this->product_instances){
			$finder = new ProductInstance();
			$this->product_instances = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->product_instances;	
	}
	function getBandwidth(){
		if(!$this->bandwiths){
			$finder = new Bandwidths();
			$this->bandwiths = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->bandwiths;
	}
	function getAddOns(){
		if(!$this->add_ons){
			$finder = new AddOn();
			$this->add_ons = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->add_ons;	
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
		$this->legacyFieldName($data,'Company', "company_id" );
		$this->legacyFieldName($data,'custom1', "domain_name" );
		$this->legacyFieldName($data,'custom2', "technology" );
		$this->legacyFieldName($data,'custom3', "monthly_rate" );
		$this->legacyFieldName($data,'custom4', "support_hours" );
		$this->legacyFieldName($data,'custom5', "hourly_rate" );
		$this->legacyFieldName($data,'custom6', "pro_bono" );
		$this->legacyFieldName($data,'custom7', "contract_on_file" );
		$this->legacyFieldName($data,'custom8', "status" );
		$this->legacyFieldName($data,'custom9', "not_monthly" );
		$this->legacyFieldName($data,'custom10', "start_date" );
		$this->legacyFieldName($data,'custom11', "end_date" );
		$this->legacyFieldName($data,'custom12', "notes" );
		$this->legacyFieldName($data,'custom19', "no_contract_on_file" );
		$this->legacyFieldName($data,'custom20', "contract_url" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaCompanyId( $value ) {
		return $this->_makeCriteriaEquals( 'Company', $value );
	}
	function makeCriteriaDomainName( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaTechnology( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaMonthlyRate( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaSupportHours( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaHourlyRate( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaProBono( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaContractOnFile( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaStatus( $value ) {
		return $this->_makeCriteriaEquals( 'custom8', $value );
	}
	function makeCriteriaNotMonthly( $value ) {
		return $this->_makeCriteriaEquals( 'custom9', $value );
	}
	function makeCriteriaStartDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom10', $value );
	}
	function makeCriteriaEndDate( $value ) {
		return $this->_makeCriteriaEquals( 'custom11', $value );
	}
	function makeCriteriaNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom12', $value );
	}
	function makeCriteriaNoContractOnFile( $value ) {
		return $this->_makeCriteriaEquals( 'custom19', $value );
	}
	function makeCriteriaContractUrl( $value ) {
		return $this->_makeCriteriaEquals( 'custom20', $value );
	}
	


}

?>
