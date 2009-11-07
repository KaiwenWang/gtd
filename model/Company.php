<?php

class Company extends ActiveRecord {

	var $datatable = "company";
	var $name_field = "name";
	var $_class_name = "Company";

	var $projects;
	var $support_contracts;
	var $invoices;
	var $payments;
	var $contacts;
	var $billing_contacts;
        protected static $schema;
    protected static $schema_json = "{	
    			'fields'   : {	
								'name' 		:  'text',
								'notes'  	:  'textarea',
								'street'  	:  'text',
								'street_2'  :  'text',
								'city'  	:  'text',
								'state'  	:  'text',
								'zip'  		:  'int',
								'phone'  	:  'text',
								'other_phone'  	:  'text',
								'billing_phone' :  'text',
								'stasi_id'  :  'int',
								'preamp_id' :  'int',
								'status'  	:  'text',
								'product'  	:  'text',
								'bay_area'  :  'bool',
								'balance'  	:  'float'
    						},
    			'required' : {
    							
    						}
    			}";
    function __construct( $id = null){
        parent::__construct( $id);
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
			if($contracts){
				foreach($contracts as $contract){
					if($contract->getInvoices()) $invoices = array_merge($invoices, $contract->getInvoices());
				}
			}
			if($projects){
				foreach($projects as $project){
					if($project->getInvoices()) $invoices = array_merge($invoices,$project->getInvoices());
				}
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
		if( !$payments) return 0;
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
			$this->contacts= getMany('Contact', array("company_id"=>$this->id));
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
	
}

?>
