<?php

function supportcontractIndex($d) {
  $r = getRenderer();

  $hidden_forms = $r->view('jsHideable', array(
    'Create New Support Contract' => $r->view('supportcontractNewForm', $d->new_contract),
    'Log Support Hour' => $r->view('supporthourNewForm', $d->new_hour)
  ));

  $contract_table =  $r->view('supportcontractTable', $d->contracts);
   
  return array(
    'title' => 'Support Contracts',
    'body' => $hidden_forms
      . $contract_table 
  );
}

?>
