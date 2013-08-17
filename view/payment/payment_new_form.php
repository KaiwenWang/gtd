<?php
function paymentNewForm( $payment, $o = array() ){
    $r = getRenderer();

    $form_options = array(
        'controller'=>'Payment',
        'action'=> 'create'
    );

    if ( isset($o['redirect']) ) $form_options['redirect'] = $o['redirect'];

    $form = new Form( $form_options );

    $fs = $form->getFieldSetFor( $payment );

    $form_fields = array(
        'Company'	    => $fs->company_id,
        'Invoice ID'	    => $fs->invoice_id,
        'Amount'	    => $fs->amount,
        'Date'      	=> $fs->date,
        'Payment Type'  => $fs->payment_type,
        'Check No.'     => $fs->check_number,
        'Notes'			=> $fs->notes,
        'Don\'t Send Reciept' => '<input type="checkbox" value="1" name="noemail" id="noemail">' 
    );
    $form->content = $r->view( 'basicFormContents', 
        $form_fields, 
        array( 'title'=>'New Payment' )
    );
    return $form->html;
}
