<?php
function paymentIndex($d){
	$r =& getRenderer();
	$hidden_forms = $r->view('jsHideable',array(
								'New Payment'	=> $r->view(
															'paymentNewForm', 
															$d->new_payment 
											   				),
                            	),
							array('open_by_default' => array('New Payment'))
							);	


	return array(
	       	'title'	=> 'Payments',
            'body'	=> $hidden_forms
                       . $r->view('paymentSearch', $d->payments, array('id'=>'payments', 'search_payment' => $d->search_payment))
	       );
}
?>
