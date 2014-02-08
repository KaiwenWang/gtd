<?php

function chargeIndex($d) {
  $r = getRenderer();

  $hidden_forms = $r->view('jsHideable', 
    array('Create New Charge' => $r->view('chargeNewForm', $d->new_charge)),
    array('open_by_default' => array('Create New Charge'))
  );

  $charge_table =  $r->view('chargeSearch', $d->charges);
   
  return array(
    'title' => 'Charge',
    'body' => $hidden_forms
      . $charge_table
  );
}

?>
