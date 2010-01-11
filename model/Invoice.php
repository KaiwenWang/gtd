<?php
class Invoice extends ActiveRecord {

	var $datatable = "invoice";
	var $name_field = "id";
	var $_class_name = "Invoice";
	var $invoice_items;
	var $company;
    protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
                            'company_id'    :  'Company',
							'type'  		:  'text',
							'start_date'  	:  'date',
							'end_date'  	:  'date',
							'pdf'  			:  'text',
							'sent_date'  	:  'date',
							'status'  		:  'text',
							'previous_balance'	:  'float',
							'new_costs'  		:  'float',
							'amount_due'	:  'float',
							'new_payments' :  'float'
						},
			'required' : {
							
						}
			}";	
    function __construct( $id = null){
        parent::__construct( $id);
    }
	function isValid(){
		$valid = true;

		if( !$this->getData('company_id')){
			$this->errors[] = 'company_id must be set';
			$valid = false;
		}
		if( !$this->getData('start_date')){
			$this->errors[] = 'start_date must be set';
			$valid = false;
		}
		if( !$this->getData('end_date')){
			 $this->errors[] =  'end_date must be set';
		}

		if ( $valid && parent::isValid()) return true;
	}
	function getName(){
		return  $this->id;
	}
	function getInvoiceItems(){
		if(!$this->invoice_items){
			$finder = new InvoiceItem();
			$this->invoice_items= $finder->find(array("invoice_id"=>$this->id));
		}
		return $this->invoice_items;	
	}
	function getNewPaymentsTotal() {
		return $this->get('new_payments');
	}
    function getNewCosts() {
		return $this->get('new_costs');
	}
	function getAmountDue(){
		return $this->get('amount_due');
	}	
    function getPreviousBalance() {
		return $this->get('previous_balance');
	}
	function getCompany(){
		$this->company = new Company( $this->getData('company_id') );
		return $this->company;	
	}
	function execute(){
		if( !$this->isValid() ) bail( $this->errors );
		
		$this->setFromCompany( 	$this->getCompany(), 
								array(
									'start_date' => $this->get('start_date'),
									'end_date' 	 =>	$this->get('end_date')
									)
								);
	}
	function setFromCompany( $company, $date_range){
		if(!is_a( $company, 'Company')) bail('setFromCompany requires first param to be a Company object');

		$this->company = $company;

		$previous_balance_date = array( 'end_date'=>$date_range['start_date'] );
		$amount_due_date = array( 'end_date'=>$date_range['end_date'] );

		$previous_balance = $this->company->calculateBalance( $previous_balance_date);
		$new_costs = $this->company->calculateCosts($date_range);
		$new_payments = $this->company->calculatePaymentsTotal($date_range);
		$amount_due = $this->company->calculateBalance($amount_due_date);

		$this->set(array(
				'company_id'=>$this->company->id,
				'type'=>'stand_alone',
				'start_date'=>$date_range['start_date'],
				'end_date'=>$date_range['end_date'],
				'previous_balance'=>$previous_balance,
				'new_costs'=>$new_costs,
				'new_payments'=>$new_payments,
				'amount_due'=>$amount_due
				)
			);
	}  
}
