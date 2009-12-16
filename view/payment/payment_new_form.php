<?php
function paymentNewForm( $payment, $o = array() ){
    $r = getRenderer();
    $form_action = isset( $o['action'] ) ? $o['action'] : 'create';
    $form = new Form( array( 'controller'=>'Payment', 'action'=> $form_action));
    $fs = $form->getFieldSetFor($payment);

    $form_fields = array(
    	'Company'		    => $fs->company_id,
    	'Amount'				    => $fs->amount,
    	'Date'      				=> $fs->date,
        'Type'                      => $fs->type,
        'Notes'                     => $fs->notes
    );

    $form->content = $r->view( 'basicFormContents', 
    							$form_fields, 
    							array( 'title'=>'New Payment')
    						  );

    return $form->html;
}
