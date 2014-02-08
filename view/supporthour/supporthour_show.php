<?php

function supporthourShow($d) {
  $r = getRenderer();

  $title = $d->support_contract->getName();

  $contract_info = $r->view('jsSwappable',
    'Support Contract Info',
    array($r->view('supportcontractInfo', $d->support_contract))
  );

  $hidden_forms = $r->view('jsMultipleButtons',
    array(
      'Log Hours' => $r->view('supporthourNewForm', $d->new_hour, array('support_contract_id' => $d->support_contract->id)),
      'Edit Hour' => $r->view('supporthourEditForm', $d->hour)
    ), 
    array('open_by_default' => array('Edit Hour'))
  );

  $hour_table = $r->view('supporthourTable', $d->support_hours, array('title' => 'Hours for ' . $title));

  return array('title' => $title,
    'controls' => '',
    'body' =>  $contract_info
      . $hidden_forms
      . $hour_table
  );
}

?>
