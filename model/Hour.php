<?php
require_once('ActiveRecord.php');
require_once('gtd/utility/main_utilities.php');
class Hour extends ActiveRecord {

	var $datatable = "hour";
	var $name_field = "description";
	var $_class_name = "Hour";

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
        return $this->getData('description');
    }
	function getHours(){
		$hours = $this->getData('hours');
    	if (!$hours) $hours = 0;
    	return $hours;
	}
	function getDiscount(){
		$hours = $this->getData('discount');
		if (!$hours) $hours = 0;
		return $hours;
	} 
	function getBillableHours(){
		return $this->getHours() - $this->getDiscount();		
	}
	function getStaff(){
	   if (!$this->staff){
	       $this->staff = new Staff( $this->getData('staff_id'));
        }
        return $this->staff;
	}
    function getStaffName(){
        $staff = $this->getStaff();
        return $staff->getName();
	}
    function is_valid( ) {
    }
}
?>
