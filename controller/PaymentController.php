<?php
class PaymentController extends PageController {
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy')
                                );

    function index( $params){
    	$search_criteria = array("sort"=>"company_id,date");
    	$search_criteria = array_merge($search_criteria, $params);

		$this->data->payments = getMany( 'Payment', $search_criteria);
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
		$c = $this->new_payments[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company',
    							 'action' => 'show',
    							 'id'=>$c->getCompany()->id
    							 ));
    }
	function update( $params){
		$c = $this->updated_payments[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company',
    							 'action' => 'show',
    							 'id'=>$c->getCompany()->id
    							 ));
    }
    function new_record(){
    }
    function destroy(){
    }

}
