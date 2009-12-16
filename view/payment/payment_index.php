<?php
function paymentIndex($d){
	$r =& getRenderer();
	$hidden_forms = $r->view('jsHideable',array(
						'New Payment'	=> $r->view(
												'paymentNewForm', 
												$d->new_payment 
											   ),
                                           ));	
	return array(
	       	'title'	=> 'Payments',
            'body'	=> $hidden_forms
                       . $r->view('paymentTable', $d->payments, array('id'=>'payments'))
	       );
}
?>
