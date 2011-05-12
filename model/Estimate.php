<?php
class Estimate extends ActiveRecord {

	var $datatable = "estimate";
	var $name_field = "name";

    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'project_id'	:  'Project',
							'name'  	:  'text',
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
	function getHours( $search_criteria = array() ){
		$criteria = array_merge( array('estimate_id'=>$this->id),
		              $search_criteria,
		              array('sort'=>'date DESC')
		            );
		$this->hours = Hour::getMany($criteria);
		return $this->hours;	
	}	
	function getFirstHour() {
		$criteria = array('estimate_id'=>$this->id, 'sort'=>'date ASC');
        return getOne('Hour',$criteria);
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
	function getBillableHours( $date_range = array()){
		$date_range	? $criteria = array( 'date_range' => $date_range)
                : $criteria = array();	
		
		$hours = $this->getHours( $criteria );

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

    function getProject() {
        if(!$this->get('project_id')) return false;
        return new Project( $this->get('project_id'));
    }
    function makeCriteriaProject($values) {
       return $this->_makeCriteriaMultiple( 'project_id', $values );
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
