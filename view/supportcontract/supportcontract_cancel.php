<?php
function supportcontractCancel($d) {
  $r = getRenderer();
 
  $contract_cancel_instructions = '<p>This form cancels this support contract. Do this if the client is <b>permanently</b> terminating this contract, and we are no longer going to host or support them. Be sure to set the correct end date for this contract.</p>';

  $d->set_end_date_to_todays_date
    ? $end_date_message = '<p>This contract had no specified end date, so the end date has been set to today\'s date.  Please make sure this is correct by editing the form below.</p>'
    : $end_date_message = '<p>This contract had a pre-set end date of '.$d->contract->get('end_date').'. Please make sure this is correct by editing the form below.</p>';

  $contract_cancel_form = $r->view('supportcontractCancelForm', $d->contract);

  return array(
    'title' => 'Cancel Contract: '.$d->contract->getName(),
    'body' =>  $contract_cancel_instructions
      . $end_date_message
      . $contract_cancel_form
  );
}

?>
