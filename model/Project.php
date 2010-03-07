<?php
class Project extends ActiveRecord {

	var $datatable = "project";
	var $name_field = "name";

    protected static $schema_json = "{	
			'fields'   : {	
							'name'  		:  'text',
							'amp_url'  		:  'text',
							'design_date'  	:  'date',
							'desinger'  	:  'text',
							'launch_date'  	:  'date',
							'discovery_date':  'date',
							'crm_notes'  	:  'textarea',
							'udm_notes'  	:  'textarea',
							'content_notes' :  'textarea',
							'custom_notes'  :  'textarea',
							'training_notes':  'textarea',
							'email_notes'  	:  'textarea',
							'domain_notes'  :  'textarea',
							'contract_notes':  'textarea',
							'other_notes'  	:  'textarea',
							'status'  	:  'text',
							'deposit'  		:  'float',
							'contract_url'  :  'text',
							'deposit_date'  :  'date',
							'other_contacts':  'textarea',
							'basecamp_id'  	:  'int',
							'final_payment' :  'float',
							'final_payment_date'	:  'date',
							'cost'  		:  'float',
							'priority'  	:  'text',
							'real_launch_date'		:  'date',
							'real_design_date' 		:  'date',
							'hour_cap'  	:  'float',
							'staff_id'  	:  'Staff',
							'company_id'  	:  'Company',
							'hourly_rate'  	:  'float',
							'hours_high'  	:  'float',
							'billing_status':  'text',
							'main_payment'  :  'float',
							'main_payment_date'		:  'date',
							'billing_type'  :  'text',
							'hours_low'  	:  'float',
                            'server'        : 'text'
						},
			'required' : {
							
						},
			'values' : {
					'status' : ['pre-design','launched']
						}
			}";

    function __construct( $id = null){
        parent::__construct( $id);
    }
    function getName(){
        return $this->getCompanyName().': '.$this->getData('name');
    }
	function getEstimates(){
		if(empty($this->estimates)){
			$finder = new Estimate();
			$this->estimates = $finder->find(array("project_id"=>$this->id));
		}
		return $this->estimates;	
	}
	function getInvoices(){
		if(empty($this->invoices)){
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
		if( !$estimates) return 0;
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getTotalHours();
		}
		return $hours;
	}
	function getBillableHours( $date_range = array() ){
		$estimates = $this->getEstimates();

		if( !$estimates) return 0;

		$billable_hours = 0;
		foreach ($estimates as $estimate){
			$billable_hours += $estimate->getBillableHours( $date_range );
		}

		return $billable_hours;
	}
	function getLowEstimate(){
		$estimates = $this->getEstimates();
		if( !$estimates) return 0;
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getLowEstimate();

		}
		return $hours;
	}
	function getHighEstimate(){
		$estimates = $this->getEstimates();
		if( !$estimates) return 0;
		$hours = 0;
		foreach ($estimates as $estimate){
			$hours += $estimate->getHighEstimate();
		}
		return $hours;
	}
	function getCompany(){
		if(empty($this->company)){
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
	   if (empty($this->staff)){
	       $this->staff = new Staff( $this->getData('staff_id'));
        }
        return $this->staff;
	}
    function getStaffName(){
        $staff = $this->getStaff();
        return $staff->getName();
	}
	function makeCriteriaActive($status){
    	return $status 	? 'status NOT LIKE "done"'
						: 'status LIKE "done"';
	}
	function calculateTotal($date_range){
		return $this->getBillableHours( $date_range ) * $this->get('hourly_rate');
	}	
	function destroyAssociatedRecords(){
		if($this->getEstimates()){
			foreach( $this->getEstimates() as $estimate){
				$estimate->destroyAssociatedRecords();
				$estimate->delete();
			}
		}
	}
}
