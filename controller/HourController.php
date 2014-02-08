<?php

class HourController extends PageController {

  public $template = 'gtd_main_template';
  var $before_filters = array('get_posted_records' => array('create', 'update', 'destroy'));

  function index($params) {
    $d = $this->data;

    if($this->search_params('hour_search')) {
      $a_year_ago = date('Y-m-d', time() - (60 * 60 * 24 * 365));
      $default_query = array('hour_search' => array('start_date' => $a_year_ago), 
      'sort' => 'date DESC');
      $hour_query = array_merge($default_query, $this->search_params('hour_search'));

      $d->hours = getMany('Hour', $hour_query);
    } else {
      $d->hours = array();    
    }
    $d->new_hour = new Hour();
    $d->new_hour->set(array(
      'staff_id' => Session::getUserId(), 
      'date' => date('Y-m-d')
    ));

    $d->new_support_hour = new Hour();
    $d->new_support_hour->set(array(
      'staff_id' => Session::getUserId(), 
      'date' => date('Y-m-d')
    ));
  }

  function show($params) {
    if (!$params['id']) bail('Required $params["id"] not present.');

    $d = $this->data;

    $d->hour = new Hour($params['id']);
    $d->estimate = new Estimate($d->hour->get('estimate_id'));
    $d->project = new Project($d->estimate->get('project_id'));

    $d->new_hour = new Hour();
    $d->new_hour->set(array(
      'estimate_id' => $params['id'], 
      'staff_id' => Session::getUserId(), 
      'date' => date('Y-m-d')
    ));

    $d->projects = Project::getAll();                  

    $d->new_estimate = new Estimate();
    $d->new_estimate->set(array('project_id' => $d->project->id));
  }

  function update($params) {
    $h = $this->updated_hours[0];
    //$h->discount_if_internal_project();
    $h->updateOrCreateWithPair();
    $project_id = $h->getProject()->id;

    isset($params['redirect'])
      ? $this->redirectTo($params['redirect'])
      : $this->redirectBack();
  }

  function new_form($params) {
    if(!$params['project_id']) {
      bail('Required parameter "project_id" is missing.');
    }

    $project = new Project($params['project_id']);

    $this->options = array('project_id' => $project->id, 
      'title' => $project->getName()
    );

    $this->data = new Hour();
    $this->data->set(array(
      'staff_id' => Session::getUserId(), 
      'date' => date('Y-m-d')
    ));
  }

  function edit_form($params) {
    if(!$params['project_id']) bail('Required parameter "project_id" is missing.');
    if(!$params['hour_id']) bail('Required parameter "id" is missing.');

    $this->data->project = new Project($params['project_id']);

    $this->options = array('project_id' => $this->data->project->id, 'title' => $this->data->project->getName());

    $this->data = new Hour($params['hour_id']);
  }

  function create($params) {
    $h = $this->new_hours[0];
    $h->updateOrCreateWithPair();

    isset($params['redirect'])  
      ? $this->redirectTo($params['redirect'])
      : $this->redirectBack();     
  }

  function search($params) {
  $a_year_ago = date('Y-m-d', time() - (60 * 60 * 24 * 365));
  $default_query = array('hour_search' => array('start_date' => $a_year_ago), 'sort' => 'date DESC');
  $c = array_merge($default_query, $this->search_params('hour_search'));
  if(isset($params['sort'])) {  
    $c['sort'] = $params['sort'];
  }

  if(!empty($params['company'])) {  
    $c['company'] = $params['company'];
  }

  if(!empty($params['staff_id'])) {  
    $c['staff_id'] = $params['staff_id'];
  }
  $this->data = Hour::getMany($c);
  $this->options = $params;
  }

  function destroy($params) {
    if(empty($params['id'])) bail('Required parameter "id" is missing.');
    $hour = new Hour($params['id']);
    $project_id = $hour->getProject()->id;
    $hour->destroy();
    $this->redirectTo(array(
      'controller' => 'Project', 
      'action' => 'show', 
      'id' => $project_id
    ));
  }

}

?>
