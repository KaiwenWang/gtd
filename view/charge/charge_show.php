<?php

function chargeShow($d) {
  $r = getRenderer();

  $title = $d->company->getName();

  $company_info = '<div class="bs-docs-example float-left" id="Details"> 
    ' . $r->view('companyInfo', $d->company) . '
    </div>';

  $charge_edit_form = '  <div id="charge-edit-container">
   ' . $r->view('chargeEditForm', $d->charge, array('class' => 'clear-left')).'
    </div>';

  $hidden_forms = $r->view('jsHideable', array(
      'New Charge' => $r->view(
        'chargeNewForm', 
        $d->new_charge, 
        array('company_id' => $d->company->id)
      ),
      'Edit Charge' => $r->view(
        'chargeEditForm', 
        $d->charge
      )
    ), 
    array('open_by_default' => array('Edit Charge'))
  );

  $charge_table = $r->view('chargeTable', $d->company->getCharges(), array('title' => 'charges for '.$d->company->getName()));

  return array('title' => $title,
    'body' => $company_info
    . $hidden_forms
    . $charge_table
  );
}

?>
