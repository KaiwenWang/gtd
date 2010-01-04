<?php

class Company extends ActiveRecord {

	var $datatable = "company";
	var $name_field = "name";
	var $_class_name = "Company";

	protected $projects;
	protected $support_contracts;
	protected $invoices;
	protected $payments;
	protected $contacts;
	protected $billing_contacts;
	protected $previous_balance;
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
	function getPayments($override_criteria=array()){
        $criteria = array_merge(array("company_id"=>$this->id), $override_criteria);
		if(!isset($this->payments)){
			$this->payments = getMany('Payment', $criteria);
		}
		return $this->payments;	
	}
	function getPaymentsTotal($criteria = array()){

        $payments = $this->getPayments($criteria);
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
	
	function getCharges($override_criteria = array()){
		if(!isset($this->charges)){
            $criteria = array_merge(array("company_id"=>$this->id),$override_criteria);
			$this->charges = getMany('Charge', $criteria );
		}
		return $this->charges;	
	}

    function getChargesTotal($criteria = array()){
        $charges = $this->getCharges($criteria);
		if(!$charges) return 0;
        return array_reduce($charges, function($total, $charge) { return $total + $charge->get('amount'); }, 0 );
    }

    function calculateSupportTotal( $date_range = array()){

		if( !isset($date_range['start_date'])){

			$date_range['start_date'] = $this->getPreviousBalanceDate();

		} elseif ( $date_range['start_date'] < $this->getPreviousBalanceDate() ){

			$date_range['start_date'] = $this->getPreviousBalanceDate();

		}

		if ( isset($date_range['end_date']) && $date_range['end_date'] < $this->getPreviousBalanceDate() ){
			return 0;
		}

		$contracts = $this->getSupportContracts();
		$total = 0;
		foreach($contracts as $c){

			$amount = $c->calculateTotal($date_range);
			$total += $amount;
		}

        return $total;
    }
    
    function calculateProjectCharges($hours) {
        if(!$hours) return 0;
        return array_reduce($hours, function($total, $hour) { return $total + $hour->getCost(); }, 0 );
    }

	function getPreviousBalance(){
		if(!$this->previous_balance){
			$this->previous_balance = getOne('CompanyPreviousBalance',array('company_id'=>$this->id, 'sort'=>'date DESC'));
		}
		return $this->previous_balance;
	}
	function getPreviousBalanceDate(){
		if( $previous_balance = $this->getPreviousBalance() ) return $previous_balance->get('date');
	}
    function getBalance( $end_date) {
		bail('getBalance is a work in progress - Ted and Margot');
		$previous_balance = $this->getPreviousBalance();
        
		$date_range = array();

        if( $previous_balance ) $date_range['start_date'] = $previous_balance->get('date'); 
        
		if( $end_date ) $date_range['end_date'] = $end_date;

		$date_range	? $search_criteria = array('for_date_range'=>$date_range)
					: $search_criteria = array();

        $project_charges = $this->calculateProjectCharges( $search_criteria);

        $support_charges = $this->calculateSupportCharges( $search_criteria );

        return $project_charges + $support_charges + $this->getChargesTotal($date_range) - $this->getPaymentsTotal($date_range);
    }
}
