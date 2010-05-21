<?php
class PaymentController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array( 'create','update','destroy'),
								 'get_search_criteria'=> array('index')
                                );

    function index( $params){
    	$search_criteria = array("sort"=>"date DESC");
		if( !empty($this->search_for_payments)) $search_criteria = array_merge($search_criteria, $this->search_for_payments);

		$this->data->payments = Payment::getMany( $search_criteria);

        $this->data->search_payment= new Payment();
        $this->data->search_payment->set($search_criteria);

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
									: $redirect = array('controller' => 'Payment',
    							 						'action' => 'index'
													);
    	$this->redirectTo( $redirect); 
		Render::msg('Payment Saved');
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
	function destroy($params){
        $params['id'] ? $payment = new Payment($params['id']) 
					  : bail('required parameter $params["id"] missing.');
		$payment->destroy();

    	isset($params['redirect'])	? $redirect = $params['redirect']
									: $redirect = array('controller' => 'Payment',
    							 						'action' => 'index'
    							 						);
  
		$this->redirectTo($redirect);			
    }
}
