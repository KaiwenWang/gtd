<?php
function contactShow($d){
	$r =& getRenderer();
	
	return array(
           'title' => 'Viewing Details for '.$d->contact->getName(),
           'body' => $r->view('contactDetail', $d->contact)
            );
}
?>