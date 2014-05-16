<?php

function estimateEditForm($e, $o = array()) {
  $r = getRenderer();
  $form = new Form(array('controller' => 'Estimate', 'action' => 'update'));
  $fs = $form->getFieldSetFor($e);

  $list_items = array(
    'Name' =>   $fs->name,
    'Description' => $fs->description,
    'Low Estimate' => $fs->low_hours,
    'High Estimate' => $fs->high_hours,
    'Due Date' => $fs->due_date,
    'Internal Details' => $fs->notes,
    'Project' => $fs->project_id,
    'Category' => $fs->category
  );  
  
  $form->content = $r->view('basicFormContents', 
    $list_items, 
    array('title' => 'Edit Estimate')
  );    
  
  return $form->html;
}

?>
