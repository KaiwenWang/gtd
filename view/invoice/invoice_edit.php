<?php
function invoiceEdit( $d, $o = array() ) {
    $r = getRenderer();
   
	$edit_form = $r->view('invoiceEditForm',$d->invoice);
	
	return array(
				'title'	=> 'Edit: '.$d->invoice->getName(),
				'body'	=> $edit_form
				);
}
