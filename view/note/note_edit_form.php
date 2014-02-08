<?php

function noteEditForm($n, $o = array()) {
  $r = getRenderer();
  $form = new Form(array('controller' => 'Note', 'action' => 'update'));
  $fs = $form->getFieldSetFor($n);

  $list_items = array(
    'Company' => $fs->company_id,
    'Staff' => $fs->staff_id,
    'Name' => $fs->name,
    'Details' => $fs->description,
    'Date' => $fs->date
  );   
  $form->content = $r->view('basicFormContents', 
    $list_items, 
    array('title' => 'Edit Note')
  );
  
  return $form->html;
}

?>
