<?php
class SupportContract extends ActiveRecord {

	var $datatable = "support_contract";
	var $name_field = "domain_name";

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
			'values'   : {
						'status' :	{'active':'Active', 'cancelled':'Cancelled'}
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
    }
    function getName(){
        return $this->getCompanyName().': '.$this->getData('domain_name');
    }
    function getShortName(){
        return $this->getData('domain_name');
    }
	function getInvoices(){
		if(!$this->invoices){
			$finder = new Invoice();
			$this->invoices = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->invoices;	
	}
    function getHours( $criteria = array()){
		$criteria = array_merge( array('support_contract_id'=>$this->id), $criteria);
        $this->hours = getMany('Hour',$criteria);
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
		if(empty($this->product_instances)){
			$finder = new ProductInstance();
			$this->product_instances = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->product_instances;	
	}
	function getBandwidth(){
		if(empty($this->bandwidths)){
			$finder = new Bandwidth();
			$this->bandwidths = $finder->find(array("support_contract_id"=>$this->id));
		}
		return $this->bandwidths;
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
	function getStartDate(){
		return $this->get('start_date');
	}
	function getEndDate(){
		return $this->get('end_date');
	}
	function isValid(){
		$valid = true;

        if(!Util::is_a_date($this->get('start_date'))) {
        	$this->errors[] = 'contract '.$this->id.' has no start date';
			$valid = false;
		}

		if ( $valid && parent::isValid()) return true;
	}
    function calculateTotal( $date_range = array() ) {
        if(!$this->isValid()) {
            bail( $this->errors );
        }

		if(!isset($date_range['start_date'])) $date_range['start_date'] = $this->get('start_date');

		if( isset($date_range['end_date']) 
			&& Util::is_a_date($this->get('end_date')) 
			&& ($date_range['end_date'] > $this->get('end_date')) ){
			
			 $date_range['end_date'] = $this->get('end_date');

		}

		$hours = $this->getHours( array( 'date_range' => $date_range ));
		
		if(!$hours) $hours = array();

        //split up by month
        $billable_hours_by_month = array();
		foreach( $hours as $hour){
            $month = date('Ym', strtotime($hour->get('date')));
            if(!isset($billable_hours_by_month[$month])) $billable_hours_by_month[$month] = 0;
            $billable_hours_by_month[$month] += $hour->getBillableHours();
        }

		// add all of the months in this date range with a monthly fee but no hours logged
        foreach($this->activeMonths($date_range) as $month_id) {
            if(!isset($billable_hours_by_month[$month_id])) $billable_hours_by_month[$month_id] = 0;
        }
		$total_charges = 0;
		foreach( $billable_hours_by_month as $month => $billable_hours) {
			$total_charges += $this->calculateMonthlyCharge( $billable_hours, $month);
        }

		return $total_charges; 
    }

    function activeMonths( $date_range = array() ) {
	
		// if there is no requested start date,
		// or the contract start date is later than the requested start date, 
		// use the contract start date instead.
        if ( isset($date_range['start_date'])){
			($date_range['start_date'] > $this->get('start_date')) ? $start_date = $date_range['start_date'] 
										 						   : $start_date = $this->get('start_date');
		} else {
			$start_date = $this->get('start_date');
		}
     	// We move the start date to the first of the month otherwise we may never see 
        // ending months that don't end on the 31st when we loop below.
		// (this also makes start date a timestamp)
        $start_date = Util::start_of_month($start_date);
       
		// if there is no requested end date,
		// or the contract end date is earlier than the requested end date, 
		// use the contract end date instead.
		if ( Util::is_a_date($this->get('end_date'))) $end_date = $this->get('end_date');

        if ( isset($date_range['end_date']) && isset($end_date)){
			($date_range['end_date'] < $end_date) ? $end_date = $date_range['end_date'] 
									 			  : $end_date = $this->get('end_date');
		} elseif( isset($date_range['end_date'])){
			$end_date = $date_range['end_date'];
		}
		// if there was no requested end date OR contract end date, use the current date 
		if( !isset($end_date) || !Util::is_a_date($end_date) ){
			$end_date = 'now';
		} 
 
		// make end date a timestamp
       	$end_date = strtotime($end_date);

		// loop over the requested months and make an array of their unique "month-id's"
        $included_months = array();
		for( $time = $start_date; $time < $end_date; $time = strtotime('+1 month', $time)){
            $included_months[] = date('Ym', $time);
        }

        return $included_months;
    }
	function getHourlyRate(){
		$this->get('hourly_rate');
	}
    function calculateMonthlyCharge($hours, $month = null) {
        //compare support hours given > support hours / month
        if( $hours <= $this->get('support_hours')) { 
            $amount = $this->calculateMonthlyBaseRate($month);
            return $amount;
        }

        $overage = $hours - $this->get('support_hours');
		if( $overage < 0) $overage = 0;

        $amount = $overage * $this->getHourlyRate() + $this->calculateMonthlyBaseRate($month);
			
        return $amount;
    }

    function calculateMonthlyBaseRate($month = null) {
        if(!$month) bail('calculateMonthlyBaseRate called without a valid month'); 
        
        $start_date = $this->get('start_date');
        $start_month = Util::is_a_date($start_date) ? date('Ym', strtotime($start_date)) : false;

		// Check to see if current month is the starting month of the contract
        if ( $month == $start_month) {
			$monthly_rate = $this->get('monthly_rate') * Util::percent_of_month_from_end( $start_date );
			return $monthly_rate;
        } 

        $end_date = $this->get('end_date');
        $end_month = Util::is_a_date($end_date) ? date('Ym', strtotime($end_date)) : false;

		// Check to see if current month is the ending month of the contract
        if ( $month == $end_month) {
			$monthly_rate =$this->get('monthly_rate') * Util::percent_of_month_from_start( $end_date );
			return $monthly_rate;
        }

        $monthly_rate = $this->get('monthly_rate');
		return $monthly_rate;
    }
	function destroyAssociatedRecords(){
		if($this->getHours()){
			foreach( $this->getHours() as $hour){
				$hour->destroyAssociatedRecords();
				$hour->delete();
			}
		}
	}
}
