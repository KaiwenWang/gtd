<?php
class Charge extends  ActiveRecord {

	var $datatable = "charge";
	var $name_field = "name";
	var $_class_name = "Charge";
    
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
    						'company_id'	:  'Company',
    						'name'  		:  'text',
    						'amount'  		:  'float',
    						'description'  	:  'textarea',
    						'date'  		:  'date',
    						'invoice_id'  	:  'Invoice'
    					},
    		'required' : {

    					}
    		}";
       
    function getCompany(  ) {
        $company = new Company( $this->get( 'company_id' ));
        return $company;
    }

    function _sort_default( &$item_set ){
        return $this->sort( $item_set, 'date', 'desc');
    }

    function getDate() {
        return $this->get( 'date' );
    }
	function getAmount(){
		return $this->get('amount');
	}
}
