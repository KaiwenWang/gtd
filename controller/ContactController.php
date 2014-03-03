<?php

class ContactController extends PageController {

  public $template = 'gtd_main_template';
  var $before_filters = array('get_posted_records' => array('create', 'update', 'destroy'));
  
  function index($params) {
    $this->data->contacts = getAll('Contact');
  }

  function show($params) {
    if(!$params['id'])  $bail('Required parameter "id" not set.');
    $this->data->contact = new Contact($params['id']);
  }

  function update($params) {
    $c = $this->updated_contacts[0];
    $c->save();
    $this->redirectTo(array(
      'controller' => 'Company', 
      'action' => 'show', 
      'id' => $c->getCompany()->id
    ));
  }

  function create($params) {
    $c = $this->new_contacts[0];
    $c->save();
    $this->redirectTo(array(
      'controller' => 'Company', 
      'action' => 'show', 
      'id' => $c->getCompany()->id
    ));
  }

  function destroy($params) {
    if(empty($params['id'])) bail('Required parameter id not set.');
    $contact = new Contact($params['id']);
    $contact->destroy();
    $this->redirectTo(array(
      'controller' => 'Contact', 
      'action' => 'index'
    ));
  }

}

?>
