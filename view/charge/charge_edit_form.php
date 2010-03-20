<?php
function chargeEditForm( $charge, $o = array(  )) {
    $r = getRenderer();
    $form = new Form( array( 'controller'=>'Charge', 'action'=> 'update'));
    $fs = $form->getFieldSetFor($charge);

    $form_fields = array(
    	'Name'	        => $fs->name,
    	'Type'	        => $fs->type,
    	'Description'	=> $fs->description,
    	'Amount'	    => $fs->amount,
    	'Date'      	=> $fs->date,
    	'Company'	    => $fs->company_id
    );

    $form->content = $r->view( 'basicFormContents', 
    							$form_fields, 
    							array( 'title'=>'Edit Charge')
    						  );

    return $form->html;
}
