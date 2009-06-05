<?php

/**
    PaymentList
    
    Displays all payments, sorted by Company ID and takes an optional filter Company id filter to limit display to just that company.
    
    $get options array:
    -<b>company_id</b> optional id of the company that we want to see their payments.
      
    @return html
    @package controller
*/

class PaymentList extends PageController {
    var $_class_name = 'PaymentList';

    function PaymentList() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r = getRenderer();
		if ($get['company_id']){
        	$c = new Company($get['company_id']);
			$payments = $c->getPayments();
        	$html = $r->view('paymentTable', $payments, array('id'=>'payments'));
		} else {
			$finder = new Payment();
	        $payments = $finder->find(array("sort"=>"Company,custom1") );
			
			$html = $r->view('paymentTable', $payments, array('id'=>'payments'));
		}

        $name = 'Payments By Company';  
        return $r->template('template/test_template.html',
                            array(
                            'name'=>$name,
                            'body'=>$html
                            ));
    }        
}
?>
