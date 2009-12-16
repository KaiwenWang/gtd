<?php
function addonIndex($d){
	$r = getRenderer();

	$hidden_forms = $r->view('jsHideable', array(
  						'Create New Add On' => $r->view( 'addonNewForm', $d->new_addon)
  						));

	$addOn_table =  $r->view('addonTable', $d->addons);
     
	return array(
			'title' => 'Add On',
			'body' => $hidden_forms
					  .$addOn_table
			);
}
