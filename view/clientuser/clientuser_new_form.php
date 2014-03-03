<?php

function clientuserNewForm($user) {
  $r = getRenderer();
  $form = new Form(array('controller' => 'ClientUser', 'action' => 'create'));
  $fs = $form->getFieldSetFor($user);
  $fields = array(
    'First Name' => $fs->first_name,
    'Last Name' => $fs->last_name,
    'Company' => $fs->company_id,
    'Email' => $fs->email,
    'Password' => $fs->password
  );
  $form->content = $r->view('basicFormContents', $fields, array('title' => 'New Client User'));
  return $form->html;
}

?>
