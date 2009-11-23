<?php
function supportcontractIndex($d){
	$r =& getRenderer();
        
	return array(
			'title' => 'Support Contracts',
			'body' => $r->view('supportcontractTable', $d->contracts)
			);
}