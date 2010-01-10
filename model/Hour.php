<?php
class Hour extends ActiveRecord {

	var $datatable = "hour";
	var $name_field = "description";
	var $_class_name = "Hour";
    
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

	var $hours;
	var $staff;
	
    function __construct( $id = null){
        parent::__construct( $id);
    }
    function getName(){
        return $this->get('description');
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
    function getCost() {
        $estimate = $this->getEstimate();
        $project = $estimate->getProject();
		if(!$project) return 0;
        return $this->get('hours') * $project->get('hourly_rate');
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
    function getEstimate(){
        if (!isset($this->estimate)){
            $this->estimate = new Estimate( $this->get('estimate_id'));
        }
        return $this->estimate;
    }

    function getStaffName(){
        $staff = $this->getStaff();
        return $staff->getName();
	}
    function is_valid( ) {
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
        /*
        if(empty($values)) return;
        if(is_array($values)) {
            return "estimate_id IN (". implode(",", $values). ")";
        }
        return "estimate_id = " . $this->dbcon->qstr( $values );
         */
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
?>
