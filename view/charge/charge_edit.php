<?php
function chargeEdit( $d, $o = array() ) {
    $r = getRenderer();
   
	$edit_form = $r->view('chargeEditForm',$d->charge);
	
	return array(
				'title'	=> 'Edit: '.$d->charge->getName(),
				'body'	=> $edit_form
				);
}
