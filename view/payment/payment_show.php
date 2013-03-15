<?php
function paymentShow( $d ) {
	$r = getRenderer( );

    $title = $d->company->getName();

	$company_info = '	<div class="bs-docs-example float-left" id="CompanyInfo"> 
	 						'.$r->view( 'companyInfo', $d->company).'
						</div>';

	$hidden_forms = $r->view('jsHideable',
							 array(
								'New Payment'	=> $r->view(
														'paymentNewForm', 
														$d->new_payment
														),
								'Edit Payment' => $r->view( 
														'paymentEditForm', 
														$d->payment
												  		)
								),
							array( 'open_by_default' => array( 'Edit Payment' ) )
					);

    $payment_table = $r->view('paymentTable', $d->company->getPayments(), array('title'=>'payments for '.$d->company->getName()));


    return array(   'title'	=> 	$title,
                    'body' 	=> 	$company_info
                    			.$hidden_forms
                    			.$payment_table
    				);

}
