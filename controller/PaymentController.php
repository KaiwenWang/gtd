<?php
class PaymentController extends PageController {

    function index( $params){
    	$search_criteria = array("sort"=>"company_id,date");
    	$search_criteria = array_merge($search_criteria, $params);

		$this->data->payments = getMany( 'Payment', $search_criteria);
    }        
}
?>
