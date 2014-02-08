<?php

function invoiceEdit($d, $o = array()) {
  $r = getRenderer();

  if ($d->invoice->getType() == 'dated') {   
    $edit_form = $r->view('invoiceEditForm', $d->invoice);
  } else {
    $edit_form = $r->view('invoiceStandEditForm', $d->invoice);
  }  

  return array(
    'title' => 'Edit: ' . $d->invoice->getName(),
    'body' => $edit_form
  );
}

?>
