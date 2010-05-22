<?php
## unfinished stub by margot for adding a stand alone invoice (what we call ones for arbitrary amounts)
function invoiceStandNewForm( $invoice, $o = array() ) {
    $r = getRenderer();
    
    $form = new Form( array( 'controller'=>'Invoice', 'action'=>'create'));
    $fs = $form->getFieldSetFor( $invoice );

    $list_items = array(
    	'Amount'    => $fs->amount_due,
        'Items' 	    => '',
        'Company'       => $fs->company_id
    );	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'New Stand Alone Invoice')
    						  );
		  
    
    return $form->html;
}
