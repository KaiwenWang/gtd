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
	function create( $params){
		$c = $this->new_payments[0];
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
