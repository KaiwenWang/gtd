<?php
class Hour extends ActiveRecord {

	var $datatable = "hour";
	var $name_field = "description";
    
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	'estimate_id' 	: 'Estimate',
							'support_contract_id' : 'SupportContract',
							'staff_id' 		: 'Staff',
							'description' 	: 'text',
							'date' 			: 'date',
							'hours' 		: 'float',
							'discount' 		: 'float',
							'basecamp_id' 	: 'int'
					   },
			'required' : {	'staff_id',
							[ 'estimate_id' , 'support_contract_id' ]
							'description',
							'date'
					   }
			}";
	
    function __construct( $id = null){
        parent::__construct( $id);
    }
    function getName(){
        return $this->get('description');
    }
	function getDate(){
		return $this->get('date');
	}
	function getHours(){
		$hours = $this->get('hours');
    	if (!$hours) $hours = 0;
    	return $hours;
	}
	function getDiscount(){
		$hours = $this->get('discount');
		if (!$hours) $hours = 0;
		return $hours;
	}
	function getHourlyRate(){
		// really you want to ask a project about this.  use this if you need itemized costs in a display.
		if($this->is_project_hour()){
			$rate = $this->getProject()->getHourlyRate();
		}else{
			$rate = $this->getSupportContract()->getHourlyRate();
		}
		return $rate;
	} 
	function getBillableAmount(){
		// really you want to ask a project about this.  use this if you need itemized costs in a display.
		return $this->getCost($this->getHourlyRate());
	}
    function getCost( $hourly_rate ) {
		// really you want to ask a project about this.  use this if you need itemized costs in a display.
        return $this->getBillableHours() * $hourly_rate;
    }
	function getBillableHours(){
		return $this->getHours() - $this->getDiscount();		
	}
	function getStaff(){
	   if (!isset($this->staff)){
	       $this->staff = new Staff( $this->get('staff_id'));
        }
        return $this->staff;
	}
	function getType(){
		if( $this->is_project_hour()) return 'project';
		else return 'support';
	}
    function getSupportContract(){
		if( !$this->get('support_contract_id')) return;
        if( !isset($this->support_contract)){
            $this->support_contract = new SupportContract( $this->get('support_contract_id'));
        }
        return $this->support_contract;
    }
    function getEstimate(){
		if( !$this->is_project_hour()) return;
        if( !isset($this->estimate)){
            $this->estimate = new Estimate( $this->get('estimate_id'));
        }
        return $this->estimate;
    }
	function getProject(){
		if( !$this->is_project_hour()) return;
        if (!isset($this->project)){
            $this->project = $this->getEstimate()->getProject();
        }
        return $this->project;
	}
    function getStaffName(){
        $staff = $this->getStaff();
        return $staff->getName();
	}
	function getCompany(){
		if( $this->is_project_hour()){
			return $this->getProject()->getCompany();
		} else {
			return $this->getSupportContract()->getCompany();
		}
	}	
	function getCompanyName(){
		return $this->getCompany()->getName();
	}
    function is_valid( ) {
    }
	function is_project_hour(){
		if($this->get('estimate_id')) return true;
	}
	function getHistoryDate(){
		return $this->getDate();
	}
	function getHistoryName(){
		if( $this->is_project_hour()){
			$name = $this->getProject()->getShortName();
		} else {
			$name = 'Support';
		}
		return $name.': '.$this->getName();
	}
	function getHistoryDescription(){
		return $this->getBillableHours().' hours at '.$this->getHourlyRate();
	}
	function getHistoryAmount(){
		return $this->getBillableAmount();
	}
    function makeCriteriaHourSearch($data) {
        return $this->makeCriteriaDateRange( $data );
    }
    function makeCriteriaSupportContract($values) {
        if(empty($values)) return;
        if(is_array($values)) {
            return "support_contract_id IN (". implode(",", $values). ")";
        }
        return "support_contract = " . $this->dbcon->qstr( $values );
    }
    function makeCriteriaEstimate($values) {
        return $this->_makeCriteriaMultiple('estimate_id', $values);
    }
    function makeCriteriaProject($values) {
        $estimates = getMany('estimate', array('project' => $values));
        return $this->makeCriteriaEstimate( 
                    array_map( function( $item ) { return $item->id; }, $estimates)
                ); 
    }
    function makeCriteriaCompany($value) {
        $projects = getMany('project', array('company_id' => $value));
		if(!$projects) return false;
        return $this->makeCriteriaProject( 
                    array_map( function( $item ) { return $item->id; }, $projects)
                ); 
    }
}
