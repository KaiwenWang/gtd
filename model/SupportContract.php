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

    function calculateCharges( $hours ) {
        //split up by month
        $hours_by_month = array_reduce( $hours, function( $months, $hour ) {
            $hour_month = date('Ym', strtotime($hour->get('date')));
            if(!isset($months[$hour_month])) $months[$hour_month] = 0;
            $months[$hour_month] += $hour->getBillableHours();
            return $months;
        }, array());

        //add in months which have no hours
        /*$months = array_keys($hours_by_month);
        sort(&$months);
        print_r($months);
        $current_month = $months[0];
        $last_month = $months[-1];
        //add_in_missing_months
        //foreach month check if in months array if not add it with 0
        /*$real_date = true;
        if($this->get('end_date') == '0000-00-00') $real_date = false;
        $end_date = $this->get('end_date') && $real_date ? $this->get('end_date') : time();
        $real_date = true;
        if($this->get('start_date') == '0000-00-00') $real_date = false;
        $sample_time = $this->get('start_date') && $real_date ? $this->get('start_date') : 
        print $sample_time;
        print $end_date;
        while( $sample_time < $end_date ) {
            $time_key = date('Ym', $sample_time);
            if(!isset($hours_by_month[$time_key])) {
                $hours_by_month[$time_key] = 0;
            }
            $next_month = date('m', $sample_time) + 1;
            $next_year = date('Y', $sample_time);
            if($next_month > 12 ) {
                $next_month = $next_month - 12;
                $next_year = $next_year + 1;
            }
            $sample_time = time( 0, 0, 0, $next_month, 1, $next_year );
        }
         */
        print("<pre>");
        print_r($hours_by_month);
        print("</pre>"); 
        $total_charges = array_map( array($this, 'calculateMonthlyCharge'), $hours_by_month);
        return array_sum($total_charges);
    }

    function activeMonths() {
    }

    function calculateMonthlyCharge($hours) {
        //compare support hours given > support hours / month
        if($hours <= $this->get('support_hours')) return $this->get('monthly_rate');
        $overage = $hours - $this->get('support_hours');
        return $overage * $this->get('hourly_rate') + $this->get('monthly_rate');
    }
}
