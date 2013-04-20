<?php
function invoiceEditForm( $invoice, $o = array() ) {
    $r = getRenderer();

    $form = new Form( array( 'controller'=>'Invoice', 'action'=>'update'));
    $fs = $form->getFieldSetFor( $invoice );

    $list_items = array(
        'Start Date'    		=> $fs->start_date,
        'End Date' 	    		=> $fs->end_date,
        'Company'       		=> $fs->company_id,
        'Additional Recipients'         => $fs->additional_recipients,
        'Status'                        => $fs->payment_status
    );	

    $form->content = $r->view( 'basicFormContents', 
        $list_items, 
        array( 'title'=>'Edit Standard Invoice')
    );


    return $form->html;
}
