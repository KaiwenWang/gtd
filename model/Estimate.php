<?php

class Estimate extends ActiveRecord {

	var $datatable = "estimate";
	var $name_field = "description";
	var $_class_name = "Estimate";
	var $hours;
    protected static $schema_json = "{	
			'fields'   : {	
							'project_id'	:  'Project',
							'description'  	:  'textarea',
							'high_hours'  	:  'float',
							'due_date'  	:  'date',
							'completed'  	:  'bool',
							'notes'  		:  'textarea',
							'low_hours'  	:  'float',
							'basecamp_id'  	:  'int'
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
    }
	function getHours(){
		if(!$this->hours){
			$finder = new Hour();
			$this->hours = $finder->find(array("estimate_id"=>$this->id));
		}
		return $this->hours;	
	}	
	function getTotalHours(){
		$hours = $this->getHours();
		$total_hours = 0;
		if( !$hours) return 0;
		foreach ($hours as $hour){
			$total_hours += $hour->getHours();
		}
		return $total_hours;
	}
	function getBillableHours(){
		$hours = $this->getHours();
		if( !$hours) return 0;
		$billable_hours = 0;
		foreach ($hours as $hour){
			$billable_hours += $hour->getBillableHours();
		}
		return $billable_hours;
	}
	function getLowEstimate(){
		return $this->getData('low_hours');
	}
	function getHighEstimate(){
		return $this->getData('high_hours');
	}
}

?>
