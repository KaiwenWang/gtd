<?php
function paymentEditForm( $payment, $o = array() ){
    $r = getRenderer();

	$form_options = array(
						'controller'=>'Payment',
						'action'=> 'update'
						);

	if ( isset($o['redirect']) ) $form_options['redirect'] = $o['redirect'];

    $form = new Form( $form_options );

    $fs = $form->getFieldSetFor( $payment );

    $form_fields = array(
    	'Company'	    => $fs->company_id,
    	'Amount'	    => $fs->amount,
    	'Date'      	=> $fs->date,
        'Payment Type'  => $fs->payment_type,
        'Check No.'     => $fs->check_number,
        'Notes'			=> $fs->notes
    	);

    $form->content = $r->view( 'basicFormContents', 
    							$form_fields, 
    							array( 'title'=>'Edit Payment')
	    						);

    return $form->html;
}
