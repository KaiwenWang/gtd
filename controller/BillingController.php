<?php
class CompanyController extends PageController {
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy')
 								);

    function index( $params){
		$three_months_ago = Util::date_format('-3 months'); 
		
		$this->data->payments = getMany( 'Payment', array('date_range'=>array('start_date'=>$three_months_ago)));
		$this->data->invoices= getMany( 'Invoices', array('date_range'=>array('start_date'=>$three_months_ago)));
		
	}
	function show($params){
		
	}
}
