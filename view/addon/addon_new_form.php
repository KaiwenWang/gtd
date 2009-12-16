<?php
function addonNewForm( $addon, $o = array() ){
    $r = getRenderer();
    $form_action = isset( $o['action'] ) ? $o['action'] : 'create';
    $form = new Form( array( 'controller'=>'AddOn', 'action'=> $form_action));
    $fs = $form->getFieldSetFor($addon);

    $form_fields = array(
    	'Name'				        => $fs->name,
    	'Description'				=> $fs->description,
    	'Amount'				    => $fs->amount,
    	'Date'      				=> $fs->date,
    	'Support Contract'		    => $fs->support_contract_id
    );

    $form->content = $r->view( 'basicFormContents', 
    							$form_fields, 
    							array( 'title'=>'New Add On')
    						  );

    return $form->html;
}
