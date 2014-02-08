<?php

function supportcontractCorrectMistake($d) {
  $r = getRenderer();
 
  $contract_instructions = '<p>This form is only to be used to edit a fuck-up.  
    If you did not already fuck up, then <b>you are fucking up right now by editing this form</b>.
    Ask Sara if you are confused.</p>';

  $contract_form = $r->view('supportcontractCorrectMistakeForm', $d->contract);

  return array(
    'title' => 'Correct Mistake on Contract: '.$d->contract->getName(),
    'body'  =>  $contract_instructions
      . $contract_form
  );
}

?>
