<?php
function chargeIndex($d){
	$r = getRenderer();

	$hidden_forms = $r->view('jsHideable', array(
  						'Create New Charge' => $r->view( 'chargeNewForm', $d->new_charge)
  						));

	$charge_table =  $r->view('chargeTable', $d->charges);
     
	return array(
			'title' => 'Charge',
			'body' => $hidden_forms
					  .$charge_table
			);
}
