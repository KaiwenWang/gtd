<?php
class InvoiceBatch extends ActiveRecord{
	var $datatable = 'invoice_batch';
	var $name_field = 'name';

	protected static $schema;
	protected static $schema_json = "{
			'fields'   : {	
                            'name'  :  'text',
							'start_date':  'date',
							'end_date' :  'date',
							'created_date' : 'date'
						},
			'required' : {'name','start_date','end_date'}
			}";

	function getInvoices(){
		return Invoice::getMany(array('batch_id'=>$this->id));
	}
	function getStartDate(){
		return $this->get('start_date');
	}
	function getEndDate(){
		return $this->get('end_date');
	}
}
