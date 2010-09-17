<?php
function clientuserEditForm($user) {
	$r = getRenderer();
	$form = new Form(array('controller'=>'ClientUser','action'=>'update'));
	$fs = $form->getFieldSetFor($user);
	$fields = array(
		'First Name' => $fs->first_name,
		'Last Name' => $fs->last_name,
		'Company' => $fs->company_id,
		'Email' => $fs->email,
		'New Password' => '<input type="text" name="new_password"/>' 
	);
	$form->content = $r->view('basicFormContents',$fields,array('title'=>'Edit Client User'));
	return $form->html;
}
