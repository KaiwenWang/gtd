<?php

function contactNewForm($c, $o = array()) {
  $r = getRenderer();
  $form = new Form(array('controller' => 'Contact', 'action' => 'create'));
  $fs = $form->getFieldSetFor($c);

  $list_items = array(
    'Company'   => $fs->company_id,
    'First Name' => $fs->first_name,
    'Last Name'   => $fs->last_name,
    'Email'   => $fs->email,
    'Phone'   => $fs->phone,
    'Fax'   => $fs->fax,
    'Billing Contact' => $fs->is_billing_contact,
    'Primary Contact' => $fs->is_primary_contact,
    'Technical Contact' => $fs->is_technical_contact
  );  
  
  $form->content = $r->view('basicFormContents', 
    $list_items, 
    array('title' => 'Add Contact')
  );
  
  return $form->html;
}

?>
