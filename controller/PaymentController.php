<?php
class PaymentController extends PageController {

    function __construct(){
        parent::__construct();
    }
    function index( $params){
    	$search_criteria = array("sort"=>"Company,custom1");
    	$search_criteria = array_merge($search_criteria, $params);

		$this->data->payments = getMany( 'Payment', $search_criteria);
    }        
}
?>
