<?php
class Invoice extends ActiveRecord {

	var $datatable = "Invoice";
	var $name_field = "date";
	var $_class_name = "Invoice";
	var $invoice_items;
	var $company;
    protected static $schema_json = "{	
			'fields'   : {	
							'support_contract_id'  :  'SupportContract',
							'project_id'	:  'Project',
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
		if ($this->getData('amount')) return $this->getData('amount');
		$items = $this->getInvoiceItems();
		$total = 0;
		foreach ($items as $item){
			$total += $item->getAmount();
		}
		return $total;
	}	
	function getCompany(){
		if(!$this->company){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}
    }

?>
