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

    function calculateCharges( $hours, $date_range = array() ) {
        if(!$this->isValid()) {
            bail( $this->errors );
        }
        //split up by month
        $hours_by_month = array_reduce( $hours, function( $months, $hour ) {
            $hour_month = date('Ym', strtotime($hour->get('date')));
            if(!isset($months[$hour_month])) $months[$hour_month] = 0;
            $months[$hour_month] += $hour->getBillableHours();
            return $months;
        }, array());

        foreach($this->activeMonths($date_range) as $month_id) {
            if(!isset($hours_by_month[$month_id])) $hours_by_month[$month_id] = 0;
        }
        //special logic for figuring out prorating on start and end dates

        $total_charges = array_map( array($this, 'calculateMonthlyCharge'), $hours_by_month, array_keys($hours_by_month));

        return array_sum($total_charges);
    }

    function activeMonths($date_range = array()) {
        if(!Util::is_a_date($this->get('start_date'))) {
            return array();
        }
        $start_point = isset($date_range['start_date']) ?$date_range['start_date'] : $this->get('start_date');
        // We move to the start of the month otherwise we may never see 
        // ending months that don't end on the 31st.
        $start_date = Util::start_of_month($start_point);

        $end_point = isset($date_range['end_date']) ?$date_range['end_date'] : $this->get('end_date');
        $end_date = Util::is_a_date($end_point) ? strtotime($end_point) : time();
        $sample_time = $start_date;
        $included_months = array();

        while( $sample_time < $end_date ) {
            $included_months[] = date('Ym', $sample_time);
            $sample_time = strtotime( '+1 month', $sample_time);
        }
        return $included_months;

    }

    function calculateMonthlyCharge($hours, $month = null) {
        //compare support hours given > support hours / month
        if($hours <= $this->get('support_hours')) { 
            $amount = $this->calculateMonthlyBaseRate($month);
            return $amount;
        }
        $overage = $hours - $this->get('support_hours');
        $amount = $overage * $this->get('hourly_rate') + $this->calculateMonthlyBaseRate($month);
        return $amount;
    }

    function calculateMonthlyBaseRate($month = null) {
        $base_rate = $this->get('monthly_rate');
        if(!$month) return $base_rate; 
        //turn month value into a date
        //check against start_date
        $start_date = $this->get('start_date');
        $start_month = Util::is_a_date($start_date) ? date('Ym', strtotime($start_date)) : false;
        if ($start_month == $month) {
            $day_of_start = date('d', strtotime($start_date));
            if($day_of_start == '01') return $base_rate;
            $days_in_month = Util::days_in_month($start_date);
            $days_of_contract = $days_in_month - $day_of_start;
            $amount_of_month_used = $days_of_contract / $days_in_month;
            return round($amount_of_month_used * $base_rate, 2);

        } 

        $end_date = $this->get('end_date');
        $end_month = Util::is_a_date($end_date) ? date('Ym', strtotime($end_date)) : false;
        if ($end_month == $month) {
            $day_of_end = date('d', strtotime($end_date));
            $days_in_month = Util::days_in_month($end_date);
            if($day_of_end == '01' || $day_of_end == $days_in_month ) return $base_rate;
            $amount_of_month_used = $day_of_end / $days_in_month;
            return round($amount_of_month_used * $base_rate, 2);
        }
        return $base_rate;

    }
}
