<?php

function hourEditForm($h, $o) {
  $r = getRenderer();
  $options = $o;
  $form = new Form(array('controller' => 'Hour', 'action' => 'update'));
  $fs = $form->getFieldSetFor($h);
  $project_id = $o['project_id'];
  $estimate_field = $fs->field('estimate_id', array('project_id' => $project_id));

  $list_items = array(
    'Estimate' => $estimate_field,
    'Description' => $fs->description,
    'Date Completed' => $fs->date,
    'Pair' => $fs->field('pair_id',array('select_none' => 'Not Paired')),
    'Hours' => $fs->hours,    
    'Discount' => $fs->discount,
    'Staff' => $fs->staff_id
  );  

  $form->content = $r->view('basicFormContents', 
    $list_items, 
    array(
      'title' => 'Edit Hour: ' . $h->getName(),
      'display' => 'inline'
    )
  );

  return $form->html;
}

?>
