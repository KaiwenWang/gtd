<?php

function jumpSelect($sample_object, $criteria = array()) {
  $r = getRenderer();
  
  $form = new Form(array(
    'method' => 'get', 
    'action' => 'show',
    'controller' => get_class($sample_object)
  ));

  $form->content = $r->objectSelect($sample_object, array('name' => 'id'), $criteria);
  
  return $form->html;
}


?>
