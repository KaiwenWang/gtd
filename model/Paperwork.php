<?php
class Paperwork extends ActiveRecord {

	var $datatable = "paperwork";
	var $name_field = "name";
    
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'company_id'	:  'Company',
							'name'  		:  'text',
							'check' 	 	:  'boolean',
							'staff_id'  	:  'Staff',
							'date'  		:  'date'
						},
			'required' : { 'staff_id,
							'name',
							'date'
							
						}
			}";

    function __construct( $id = null){
        parent::__construct( $id);
    }
	function getName(){
		return $this->getData('name');
	}
    function getCompany(){
		if(empty($this->company)){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}
	function getDate(){
		return $this->get('date');
	}
	function getCheck(){
		return $this->get('check');
	}
	function getStaff(){
		if (empty($this->staff)){
	       $this->staff = new Staff( $this->get('staff_id'));
        }
        return $this->staff;
	}
}
