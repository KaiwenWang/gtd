<?php

class SupportContract extends ActiveRecord {

	var $datatable = "support_contract";
	var $name_field = "domain_name";
	var $_class_name = "SupportContract";
	var $invoices;
	var $hours;
	var $add_ons;
	var $product_instances;
	var $bandwidths;
    var $company;
        protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'company_id'  	:  'Company',
							'replacement_contract_id' : 'SupportContract',
							'previous_contract_id' : 'SupportContract',
							'domain_name'  	:  'text',
							'technology'  	:  'text',
							'monthly_rate'  :  'float',
							'support_hours' :  'float',
							'hourly_rate'  	:  'float',
							'pro_bono'  	:  'bool',
							'contract_on_file' 		:  'bool',
							'no_contract_on_file'  	:  'bool',							
							'status'  		:  'text',
							'not_monthly'  	:  'bool',
							'start_date'  	:  'date',
							'end_date'  	:  'date',
							'notes'  		:  'textarea',
							'contract_url'  :  'text',
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
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
        if( !$hours ) return $total_hours;
        foreach ($hours as $hour){
            $total_hours += $hour->getHours();
        }
        return $total_hours;
    }
    function getBillableHours(){
        $hours = $this->getHours();
        $billable_hours = 0;
        if( !$hours ) return $billable_hours;
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
		if(!$this->bandwidths){
			$finder = new Bandwidth();
			$this->bandwidths = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->bandwidths;
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
	}

?>
