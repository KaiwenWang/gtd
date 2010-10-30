<?php
function noteIndex($d){
	$r =& getRenderer();

	return array(
		'title'	=> 'Listing All Notes',
		'body'	=> $r->view('noteTable', $d->notes, array('id'=>'Note'))
		);
}
?>
