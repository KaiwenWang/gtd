<?php
function invoicebatchNewForm( $batch, $o = array() ) {
    $r = getRenderer();
    
    $form = new Form( array( 'controller'=>'InvoiceBatch', 'action'=>'create'));
    $fs = $form->getFieldSetFor( $batch);

    $list_items = array(
        'Name'       => $fs->name,
    	'Start Date' => $fs->start_date,
        'End Date' 	 => $fs->end_date,
        'Created Date'=> $fs->created_date
    );	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'New Statement Batch')
    						  );
		  
    
    return $form->html;
}
