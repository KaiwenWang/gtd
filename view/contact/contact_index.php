<?php
function contactIndex($d){
	$r =& getRenderer();

	return array(
		'title'	=> 'Listing All Contacts',
		'body'	=> $r->view('contactTable', $d->contacts, array('id'=>'Contact'))
		);
}
?>