<?php
class Client extends User{

	var $datatable = "client";
	var $name_field = "first_name";
        
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'first_name'	:  'text',
							'last_name'  	:  'text',
							'email'  		:  'text',
							'company_id'	:  'Company',
							'username'  	:  'text',
							'password'  	:  'text'
						},
			'required' : {
							
						},
			'values'{

					}
			}";

	function __construct( $id = null){
        parent::__construct( $id);
    }
	
	function getUserType(){
		return 'client';
	}
}
