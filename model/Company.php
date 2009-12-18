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
        if(!isset($this->invoices)) {
            $this->invoices = getMany( 'Invoice', array('company_id' => $this->id));
		}
		return $this->invoices;
	}
	function getPayments(){
		if(!isset($this->payments)){
			$this->payments = getMany('Payment',array("company_id"=>$this->id));
		}
		return $this->payments;	
	}
	function getPaymentsTotal(){
        $payments = $this->getPayments();
        if(empty($payments)) return 0;
        return array_reduce($payments, 
            function( $total, $pymt) { 
                return $total + $pymt->getAmount(); 
            }, 0 );
	}

	function getTotalInvoices(){
		$invoices = $this->getInvoices();
		$total_invoices = 0;
		foreach ($invoices as $invoice){
			$total_invoices += $invoice->getAmount();
		}
		return $total_invoices;
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
	
	function getCharges(){
		if(!isset($this->charges)){
			$finder = new Charge();
			$this->charges = $finder->find(array("company_id"=>$this->id));
		}
		return $this->charges;	
	}

    function getChargesTotal(){
        $charges = $this->getCharges();
        return array_reduce($charges, function($total, $charge) { return $total + $charge->get('amount'); }, 0 );
    }

    function getSupportHours() {
        $support_contracts = getMany('SupportContract', array('company_id' => $this->id));
        $support_contract_ids = array_map(function($sc) { return $sc->id; }, $support_contracts);
        return getMany( 'Hour', array( 'support_contract' => $support_contract_ids ));
    }

    function calculateSupportCharges($support_hours){
        //split up by supportcontract id
        $hours_by_contract = array_reduce($support_hours, function($contracts, $hour) {
            $contract_id = $hour->get('support_contract_id');
            if(!isset($contracts[$contract_id])) $contracts[$contract_id] = array();

            $contracts[$contract_id][] = $hour;
            return $contracts;
        }, array());
        print count($hours_by_contract); 
        $total = 0;
        foreach( $hours_by_contract as $contract_id => $contract_hours ) {
            $contract = new SupportContract( $contract_id );
            print "Got Contract $contract_id";
            $total += $contract->calculateCharges($contract_hours);
        }
        return $total;
    }

    
    function getProjectHours() {
        $projects = getMany('Project', array('company_id' => $this->id));
        $project_ids = array_map(function($p) { return $p->id; }, $projects);
        $estimates = getMany('Estimate', array('project' => $project_ids));
        $estimate_ids = array_map(function($p) { return $p->id; }, $estimates);
        return getMany( 'Hour', array( 'estimate' => $estimate_ids ));
    }

    function calculateProjectCharges($hours) {
        if(!$hours) return 0;
        return array_reduce($hours, function($total, $hour) { return $total + $hour->getCost(); }, 0 );
    }

    function getBalance() {
        $project_hours = $this->getProjectHours();
        $project_charges = $this->calculateProjectCharges($project_hours);

        $support_hours = $this->getSupportHours();
        $support_charges = $this->calculateSupportCharges($support_hours);
        return $project_charges + $support_charges + $this->getChargesTotal() - $this->getPaymentsTotal();
    }
}
