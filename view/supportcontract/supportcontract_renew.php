<?php

function supportcontractRenew($d) {
  $r = getRenderer();
 
  $contract_renew_instructions = '<p>This form cancels the existing support contract and creates a new ongoing support contract. 
    Do this whenever there is a change to an existing contract, such as number of support hours per month or hourly rate, 
    that should only effect support hours being logged from this point onwards, while leaving previously logged hours the same. 
    Are you sure this is what you want to do?</p>';

  $contract_renew_form = $r->view('supportcontractRenewForm', $d->new_contract);

  return array(
    'title' => 'Renew Contract: '.$d->new_contract->getName(),
    'body' => $contract_renew_instructions
      . $contract_renew_form
  );
}

?>
