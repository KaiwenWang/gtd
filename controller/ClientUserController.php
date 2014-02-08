<?php

class ClientUserController extends PageController{

  public $template = 'gtd_main_template';
  var $before_filters = array(
    'get_posted_records' => array('create', 'update', 'destroy'), 
    'get_search_criteria' => array('index')
  );

  function index($params) {
    $criteria = array();
    if(!empty($this->search_for_clientusers)) $criteria = $this->search_for_clientusers;
    $criteria['sort'] = 'last_name, first_name';

    $this->data->clientusers = ClientUser::getMany($criteria);

    $this->data->new_clientuser = new ClientUser();

    $this->data->search_clientuser = new ClientUser();
    $this->data->search_clientuser->set($criteria); 
  }

  function edit($params) {  
    $params['id']
      ? $this->data->clientuser = new ClientUser($params['id'])
      : bail('no company selected');
  }

  function create($params) {
    $client = $this->new_client_users[0];
    if(empty($client)) bail('No ClientUser model was submitted.');
    $client->encryptPassword();
    $client->save();
    Render::msg($client->getName().' Created.');  
    $this->redirectTo(array('controller' => 'ClientUser', 'action' => 'index'));
  }

  function update($params) {
    $client = $this->updated_client_users[0];
    if(empty($client)) bail('No ClientUser model was submitted.');
    if(!empty($params['new_password'])) {
      $client->setPassword($params['new_password']);
    }
    $client->save();
    Render::msg($client->getName().' Updated.');  
    $this->redirectTo(array('controller' => 'ClientUser', 'action' => 'index'));
  }

  function destroy($params) {
    $params['id']  
      ? $clientuser = new ClientUser($params['id'])
      : bail('no company selected');
    $name = $clientuser->getName();
    $clientuser->destroy();
    Render::msg($name . ' Deleted.', 'bad');  
    $this->redirectTo(array('controller' => 'ClientUser', 'action' => 'index'));
  }

}

?>
