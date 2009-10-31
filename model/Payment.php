<?php

class Payment extends ActiveRecord {

	var $datatable = "payment";
	var $name_field = "amount";
	var $_class_name = "Payment";
	var $company;
    protected static $schema_json = "{	
			'fields'   : {	
							'date'  	:  'date',
							'amount'  	:  'float',
							'type'		:  'text',
							'preamp_id' :  'int',
							'preamp_client_id'  :  'int',
							'product'  	:  'text',
							'invoice_id':  'Invoice',
							'company_id':  'Company',
							'notes'  	:  'textarea'
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
    }
    function getAmount(){
            return $this->getData('amount');
    }
    function getCompany(){
            if(!$this->company){
                    $this->company = new Company( $this->getData('company_id'));
            }
            return $this->company;	
    }
    function getCompanyName(){
        $company = $this->getCompany();
        return $company->getName();
	}
	
}

?>
