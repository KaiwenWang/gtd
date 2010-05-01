<?php
class CompanyPreviousBalance extends ActiveRecord{
	var $datatable = 'company_previous_balance';

    protected static $schema;
	protected static $schema_json = "{ 
				'fields' : {
							'company_id' : 'Company',
							'date' : 'date',
							'amount' : 'float' 
							},
				'required' : {

							}
				}";

	function getAmount(){
		return $this->get('amount');
	}
	function getDate(){
		return $this->get('date');
	}
}
