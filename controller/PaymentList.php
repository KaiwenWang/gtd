<?php

class PaymentList extends PageController {
    var $_class_name = 'PaymentList';

    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
		if ($get['company_id']){
        	$c = new Company($get['company_id']);
			$payments = $c->getPayments();
        	$html = $r->view('paymentTable', $payments, array('id'=>'payments'));
		} else {
			$payments = getMany( 'Payment', array("sort"=>"Company,custom1"));
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
