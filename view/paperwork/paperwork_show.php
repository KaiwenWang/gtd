<?php
function paperworkShow($d){
	$r =& getRenderer();
	
	return array(
           'title' => 'Viewing Details for '.$d->paperwork->getName(),
           'body' => $r->view('paperworkEditForm', $d->paperwork)
            );
}
?>
