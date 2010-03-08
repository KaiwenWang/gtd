<?php
class Contact extends ActiveRecord {

	var $datatable = "contact";
	var $name_field = "first_name";
    
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'first_name':  'text',
							'last_name'	:  'text',
							'company_id':  'Company',
							'title'  	:  'text',
							'notes'  	:  'textarea',
							'email'  	:  'text',
							'phone'  	:  'text',
							'fax'  		:  'text',
							'street'  	:  'text',
							'street_2'  :  'text',
							'city'  	:  'text',
							'state'  	:  'text',
							'zip'  		:  'int',
							'is_billing_contact'	:  'bool',
							'is_primary_contact'	:  'bool',
							'is_technical_contact'  :  'bool',
							'preamp_id' :  'int',
							'stasi_id'  :  'int',
							'stasi_project_id'		:  'int',
							'help_id'  	:  'int'
						},
			'required' : {
							
						}
			}";

    function __construct( $id = null){
        parent::__construct( $id);
    }
	function getName(){
		$name = $this->getData('first_name');
		if( $this->getData('last_name')) $name .= ' '.$this->getData('last_name');
		return $name;
	}
    function getCompany(){
		if(empty($this->company)){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}

}
