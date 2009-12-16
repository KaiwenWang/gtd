<?php
function chargeNewForm( $charge, $o = array() ){
    $r = getRenderer();
    $form_action = isset( $o['action'] ) ? $o['action'] : 'create';
    $form = new Form( array( 'controller'=>'Charge', 'action'=> $form_action));
    $fs = $form->getFieldSetFor($charge);

    $form_fields = array(
    	'Name'				        => $fs->name,
    	'Description'				=> $fs->description,
    	'Amount'				    => $fs->amount,
    	'Date'      				=> $fs->date,
    	'Company'		    => $fs->company_id
    );

    $form->content = $r->view( 'basicFormContents', 
    							$form_fields, 
    							array( 'title'=>'New Charge')
    						  );

    return $form->html;
}
