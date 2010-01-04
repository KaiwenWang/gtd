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
		//stub
	}	
	function getCompany(){
		if(!$this->company){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}

    function calculateTotals() {
    	//stub
	}

    function getCharges() {
        if(isset($this->charges)) return $this->charges;
        $date_range = array('start_date'    => $this->get('start_date'), 
                            'end_date'      => $this->get('end_date'));
        $this->charges = $this->getCompany()->getCharges(array('for_date_range' => $date_range, 'sort' => 'date'));
        return $this->charges;
    }
    function getSupportHours() {
        if(isset($this->support_hours)) return $this->support_hours;

        $date_range = array('start_date'    => $this->get('start_date'), 
                            'end_date'      => $this->get('end_date'));
        $this->support_hours = $this->getCompany()->getSupportHours(array('for_date_range' => $date_range, 'sort' => 'date'));
        return $this->support_hours; 
    }

    function getProjectHours() {
        if(isset($this->hours)) return $this->hours;
        $date_range = array('start_date'    => $this->get('start_date'), 
                            'end_date'      => $this->get('end_date'));
        $this->hours = $this->getCompany()->getProjectHours(array('for_date_range' => $date_range, 'sort' => 'date'));
        return $this->hours;
    }
}
