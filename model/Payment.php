<?php
class Payment extends ActiveRecord {

	var $datatable = "payment";
	var $name_field = "amount";

    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'date'  	:  'date',
							'amount'  	:  'float',
							'payment_type' :  'text',
							'preamp_id' :  'int',
							'preamp_client_id'  :  'int',
							'product'  	:  'text',
							'invoice_id':  'Invoice',
							'company_id':  'Company',
							'notes'  	:  'textarea',
                            'check_number' : 'text'
						},
			'required' : {
							
						}
			}";

    function getAmount(){
            return $this->getData('amount');
    }
    function getCompany(){
            if(empty($this->company)){
                    $this->company = new Company( $this->get('company_id'));
            }
            return $this->company;	
    }
    function getCompanyName(){
        $company = $this->getCompany();
        return $company->getName();
	}
    function getDate() {
        return $this->get( 'date' );
    }

    function _sort_default( &$item_set ){
        return $this->sort( $item_set, 'date', 'desc');
    }

}
