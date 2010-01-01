<?php
class PaymentController extends PageController {
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy')
                                );

    function index( $params){
    	$search_criteria = array("sort"=>"date DESC");
    	$search_criteria = array_merge($search_criteria, $params);

		$this->data->payments = getMany( 'Payment', $search_criteria);

        $this->data->new_payment= new Payment();
		$this->data->new_payment->set(array( 
										'date' => date('Y-m-d') ));
    }        
    function show($params) {
        $params['id'] ? $this->data->payment = new Payment($params['id']) 
					  : Bail('required parameter $params["id"] missing.');

        $this->data->company= $this->data->payment->getCompany();

        $this->data->new_payment= new Payment();
		$this->data->new_payment->set(array( 
										'date' => date('Y-m-d'),
									  	'company_id' => $this->data->company->id ));
    }
	function create( $params){
		$p = $this->new_payments[0];

    	$p->save();

    	isset($params['redirect'])	? $redirect = $params['redirect']
									: $redirect = array('controller' => 'Company',
    							 						'action' => 'show',
    							 						'id' => $p->get('company_id')
    							 						);

    	$this->redirectTo( $redirect); 
    }
	function update( $params){
		$p = $this->updated_payments[0];
 
    	$p->save();

    	isset($params['redirect'])	? $redirect = $params['redirect']
									: $redirect = array('controller' => 'Payment',
    							 						'action' => 'show',
    							 						'id' => $p->id
    							 						);

    	$this->redirectTo( $redirect); 
    }
    function new_record(){
    }
    function destroy(){
    }
}
