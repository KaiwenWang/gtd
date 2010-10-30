<?php
function noteShow($d){
	$r =& getRenderer();
	
	return array(
           'title' => 'Viewing Details for '.$d->note->getName(),
           'body' => $r->view('noteEditForm', $d->note)
            );
}
?>
