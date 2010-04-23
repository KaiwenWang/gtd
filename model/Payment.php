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
							'invoice_id':  'int',
							'company_id':  'Company',
							'notes'  	:  'textarea',
                            'check_number' : 'text'
						},
			'required' : {
							
						},
			'values'   : {
				'payment_type':{'check':'Check','paypal':'Paypal','direct':'Direct Deposit','cash':'Cash','credit':'Credit'}
						},
			}";

    function getAmount(){
            return $this->get('amount');
    }
    function getType(){
            return $this->get('payment_type');
    }
    function getCheckNumber(){
            return $this->get('check_number');
    }
    function getDate() {
        return $this->get( 'date' );
    }
	function getNotes(){
		return $this->get('notes');
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
    function _sort_default( &$item_set ){
        return $this->sort( $item_set, 'date', 'desc');
    }
	function getHistoryName() {
		if( $this->getType() == 'check') {
			return 'Payment: Check  #'. $this->getCheckNumber();
		} else {
			return 'Payment: '. ucwords($this->getType()); 	
		}		
	}
	function getHistoryDate(){
		return $this->getDate();
	}
	function getHistoryDescription(){
		return $this->getNotes();
	}
	function getHistoryAmount(){
		return $this->getAmount();
	}
}
