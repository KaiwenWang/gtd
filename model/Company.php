<?php
class Company extends ActiveRecord {

	var $datatable = "company";
	var $name_field = "name";

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
								'country'	:  'text',
								'preamp_id' :  'int',
								'status'  	:  'text',
								'bay_area'  :  'bool',
								'date_started' : 'date',
								'date_ended':  'date',
								'org_type':'text',
								'fax' : 'text'
    						},
    			'required' :{ 
    							'name','date_started',
								'org_type','status'
    						},
				'values' : {
							'status' : {'setup':'Setup','active':'Active','rEvent':'rEvent','closed':'Closed','free':'Low-Bagger','short':'Shortpants','off':'Uncontrolled Server'},
							'org_type' : {'501c3':'501c3','other':'other'},
							'country' : {'usa':'USA','canada':'Canada','international':'International'}
							}
    			}";

	function getProjects(){
		if(empty($this->projects)){
			$this->projects= getMany('Project',array("company_id"=>$this->id));
		}
		return $this->projects;	
	}
	function getSupportContracts(){
		if(empty($this->support_contracts)){
			$this->support_contracts = getMany('SupportContract',array("company_id"=>$this->id));
		}
		return $this->support_contracts;
	}
	function getInvoices(){
        $this->invoices = getMany( 'Invoice', array('company_id' => $this->id));
		return $this->invoices;
	}
	function getPayments($override_criteria=array()){
        $criteria = array_merge(array("company_id"=>$this->id), $override_criteria);
		$this->payments = getMany('Payment', $criteria);
		return $this->payments;	
	}
	function getContacts(){
		if(empty($this->contacts)){
			$this->contacts= getMany('Contact', array("company_id"=>$this->id));
		}
		return $this->contacts;	
	}
	function getBillingContacts(){
		if(empty($this->billing_contacts)){
			$finder = new Contact();
			$this->billing_contacts= $finder->find(array("company_id"=>$this->id,"billable"=>1));
		}
		return $this->billing_contacts;	
	}
	function getCharges($override_criteria = array()){
        $criteria = array_merge(array("company_id"=>$this->id),$override_criteria);
		$this->charges = getMany('Charge', $criteria );
		return $this->charges;	
	}
	function getPrimaryContact(){
		return Contact::getOne(array('company_id'=>$this->id,'is_primary_contact'=>true));
	}
	function getBillingContact(){
		return Contact::getOne(array('company_id'=>$this->id,'is_billing_contact'=>true));
	}
	function getTechnicalContact(){
		return Contact::getOne(array('company_id'=>$this->id,'is_technical_contact'=>true));
	}
    function calculateChargesTotal($date_range = array()){

		$date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

		if( !$date_range ) return 0;

        $charges = $this->getCharges( array( 'date_range'=> $date_range) );

		if(!$charges) return 0;

		$total = 0;
		foreach( $charges as $charge){
			$total += $charge->getAmount();
		}

		return $total;
    }

	function calculatePaymentsTotal($date_range = array()){
		$date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

		if( !$date_range ) return 0;

        $payments = $this->getPayments(array('date_range'=>$date_range));

        if(!$payments) return 0;
		
		$total = 0;
		foreach( $payments as $payment ){
			$total += $payment->getAmount();
		}

		return $total;
	}

	function calculateInvoiceTotal(){
		$invoices = $this->getInvoices();
		$total_invoices = 0;
		foreach ($invoices as $invoice){
			$total_invoices += $invoice->getAmount();
		}
		return $total_invoices;
	}

    function calculateSupportTotal( $date_range = array() ){

		$date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

		if( !$date_range ) return 0;

		$contracts = $this->getSupportContracts();

		if(!$contracts) return 0;

		$total = 0;
		foreach($contracts as $c){
			$amount = $c->calculateTotal($date_range);
			$total += $amount;
		}

        return $total;
    }

    function calculateProjectsTotal( $date_range = array() ) {
		$date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

		if( !$date_range ) return 0;
		
		$projects = $this->getProjects();
		
        if(!$projects) return 0;

		$total = 0;
		foreach($projects as $project){
			$total += $project->calculateTotal($date_range);
		}	
	
		return $total;
    }
	
	function calculateCosts($date_range = array()) {
		if( empty($date_range['end_date'])) bail('$date_range["end_date"] required');

		$date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

		if( !$date_range ) return 0;

		$support_total = $this->calculateSupportTotal( $date_range );
		$project_total = $this->calculateProjectsTotal( $date_range );
		$charges_total = $this->calculateChargesTotal( $date_range );
		
		return $support_total + $project_total + $charges_total;
	}

	function getPreviousBalance(){
		if(empty($this->previous_balance)){
			$this->previous_balance = CompanyPreviousBalance::getOne(array('company_id'=>$this->id, 'sort'=>'date DESC'));
		}
		return $this->previous_balance;
	}

	function getPreviousBalanceDate(){
		if( $previous_balance = $this->getPreviousBalance() ) return $previous_balance->get('date');
	}


    function calculateBalance( $date_range = array()) {
		if( empty($date_range['end_date'])) bail('$date_range["end_date"] required');

		$date_range = $this->updateDateRangeWithPreviousBalanceDate($date_range);

		if( !$date_range ) return 0;
		
		$current_balance = $this->calculateCosts($date_range) - $this->calculatePaymentsTotal($date_range);
		$previous_balance = $this->getPreviousBalance();
		
		return $current_balance + $previous_balance->getAmount();
	}

	function updateDateRangeWithPreviousBalanceDate( $date_range ){

		if( !isset($date_range['start_date'])){

			$date_range['start_date'] = $this->getPreviousBalanceDate();

		} elseif ( $date_range['start_date'] < $this->getPreviousBalanceDate() ){

			$date_range['start_date'] = $this->getPreviousBalanceDate();

		}

		if ( isset($date_range['end_date']) && $date_range['end_date'] <= $this->getPreviousBalanceDate() ){
			return false;
		}
		
		return $date_range;

	}
	function destroyAssociatedRecords(){
		if($this->getProjects()){
			foreach( $this->getProjects() as $project){
				$project->destroyAssociatedRecords();
				$project->delete();
			}
		}
		if($this->getPayments()){
				foreach( $this->getPayments() as $payment){
				$payment->destroyAssociatedRecords();
				$payment->delete();
			}
		}
		if($this->getCharges()){
			foreach( $this->getCharges() as $charge){
				$charge->destroyAssociatedRecords();
				$charge->delete();
			}
		}
		if($this->getSupportContracts()){
			foreach( $this->getSupportContracts() as $contract){
				$contract->destroyAssociatedRecords();
				$contract->delete();
			}
		}
		if($this->getContacts()){
			foreach( $this->getContacts() as $contact){
				$contact->destroyAssociatedRecords();
				$contact->delete();
			}
		}
	}
}
