<?php
function invoiceStandEditForm( $invoice, $o = array() ) {
    $r = getRenderer();

    $form = new Form( array( 'controller'=>'Invoice', 'action'=>'update'));
    $fs = $form->getFieldSetFor( $invoice );

    $list_items = array(
        'Amount'    => $fs->amount_due,
        'Date'    => $fs->date,
        'Company'       => $fs->company_id,
        'Details'   => $fs->details,
        'Status' => $fs->payment_status
    );	

    $form->content = $r->view( 'basicFormContents', 
        $list_items, 
        array( 'title'=>'Edit Stand-Alone Statement')
    );


    return $form->html;
}
