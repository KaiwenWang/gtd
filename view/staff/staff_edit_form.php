<?php
function staffEditForm($user) {
  $r = getRenderer();
  $form = new Form(array('controller'=>'Staff','action'=>'update'));
  $fs = $form->getFieldSetFor($user);
  $fields = array(
    'Username' => $fs->username,
    'First Name' => $fs->first_name,
    'Last Name' => $fs->last_name,
    'Email' => $fs->email,
    'Team' => $fs->team,
    'New Password' => '<input type="password" name="new_password"/>', 
    'Repeat Password' => '<input type="password" name="new_password_repeat"/>', 
    'Avatar' => $fs->avatar,
    'Active' => $fs->active
  );
  $form->content = $r->view('basicFormContents', $fields, array('title'=>'Edit Staff'));
  return $form->html;
}
