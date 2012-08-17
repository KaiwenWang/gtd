<?php
function paperworkIndex($d){
	$r =& getRenderer();
	
	return array(
		'title'	=> 'Listing All Paperworks',
		'body'	=> $r->view('paperworkNewForm', $d->paperwork) . $r->view('paperworkTable', $d->paperworks, array('id'=>'Paperwork'))
		);
}
?>
