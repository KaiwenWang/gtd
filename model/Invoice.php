<?php
class Invoice extends ActiveRecord {

	var $datatable = "invoice";
	var $name_field = "date";
	var $_class_name = "Invoice";
	var $invoice_items;
	var $company;
        protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
							'support_contract_id'  :  'SupportContract',
							'project_id'	:  'Project',
                            'company_id'    :  'Company',
							'type'  		:  'text',
							'start_date'  	:  'date',
							'end_date'  	:  'date',
							'pdf'  			:  'text',
							'url'  			:  'text',
							'html'  		:  'textarea',
							'sent_date'  	:  'date',
							'date'  		:  'date',
							'amount'  		:  'float'
						},
			'required' : {
							
						}
			}";	
    function __construct( $id = null){
        parent::__construct( $id);
    }
	function getInvoiceItems(){
		if(!$this->invoice_items){
			$finder = new InvoiceItem();
			$this->invoice_items= $finder->find(array("invoice_id"=>$this->id));
		}
		return $this->invoice_items;	
	}
	function getAmount(){
		#if ($this->get('amount')) return $this->get('amount');
        return $this->calculateTotals();
	}	
	function getCompany(){
		if(!$this->company){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}

    function calculateTotals() {
        $company = $this->getCompany();
        $amount = $company->getBalance();
        $this->set(array('amount' => $amount ));
        return $amount;
    }
}
