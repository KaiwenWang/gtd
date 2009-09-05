<?php
function paymentIndex($d){
	$r =& getRenderer();
	
	return array(
	       	'title'	=> 'Payments',
	      	'body'	=> $r->view('paymentTable', $d->payments, array('id'=>'payments'))
	       );
}
?>