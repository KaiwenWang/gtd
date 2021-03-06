<?php

function supporthourNewForm($h, $o = array()) {
  $r = getRenderer();
  
  $form = new Form(array(
    'controller' => 'SupportHour', 
    'action' => 'create'
  ));

  if(isset($o['redirect'])) $form_options['redirect'] = $o['redirect'];

  $fs = $form->getFieldSetFor($h);

  $list_items = array(
    'Support Contract' => $fs->field('support_contract_id', array('status' => 'active')),
    'Description' => $fs->description,
    'Staff' => $fs->staff_id,
    'Pair' => $fs->field('pair_id', array('select_none' => 'Not Paired')),
    'Hours' => $fs->hours,    
    'Discount' => $fs->discount,
    'Date Completed' => $fs->date
  );  

  $form->content = $r->view('basicFormContents', 
    $list_items, 
    array('title' => 'Add Hour', 'display' => 'inline')
  );

  return '<div id="log-hours-for-support">' . $form->html . '</div>';
}

?>
