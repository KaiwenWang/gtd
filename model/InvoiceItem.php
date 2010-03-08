<?php
class InvoiceItem extends ActiveRecord {

	var $datatable = "invoice_item";
	var $name_field = "name";

    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'invoice_id'  	:  'Invoice',
							'name'  		:  'text',
							'description'  	:  'textarea',
							'amount'  		:  'float',
							'date'  		:  'date',
							'type'  		:  'text'
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
}
