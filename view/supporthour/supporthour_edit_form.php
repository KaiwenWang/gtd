<?php

function supporthourEditForm($h, $o = array()) {
  $r = getRenderer();

  $form = new Form(array('controller' => 'SupportHour', 'action' => 'update'));
  $fs = $form->getFieldSetFor($h);

  $list_items = array(
    'Support Contract' => $fs->support_contract_id,
    'Description' => $fs->description,
    'Staff' => $fs->staff_id,
    'Pair' => $fs->field('pair_id',array('select_none' => 'Not Paired')),
    'Hours' => $fs->hours,    
    'Discount' => $fs->discount,
    'Date Completed' => $fs->date
  );  

  $form->content = $r->view(
    'basicFormContents', 
    $list_items, 
    array('title' => 'Edit Hour', 'display' => 'inline')
  );  

  return '<div id="edit-hours-for-support">' . $form->html . '</div>';
}

?>
