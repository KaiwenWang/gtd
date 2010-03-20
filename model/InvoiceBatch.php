<?
class InvoiceBatch extends ActiveRecord{
	var $datatable = 'invoice_batch';
	var $name_field = 'name';

	protected static $schema;
	protected static $schema_json = "{
			'fields'   : {	
                            'name'  :  'text',
							'date'	:  'date'
						}
			}";

	function getInvoices(){
		return Invoice::getMany(array('batch_id'=>$this->id));
	}
}
