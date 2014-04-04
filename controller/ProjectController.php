<?php

class ProjectController extends PageController {

  public $template = 'gtd_main_template';
  var $before_filters = array('get_posted_records' => array('create', 'update', 'destroy'), 'get_search_criteria' => array('index'));

  function index($params) {
    $criteria = array();
    if(!empty($this->search_for_projects)) $criteria = $this->search_for_projects;
    $criteria['sort'] = array('sort' => 'status DESC, launch_date');
        
    $this->data->projects = Project::getMany($criteria);
    $this->data->new_project = new Project();
    $this->data->new_project->set(array('staff_id' => Session::getUserId()));
    $this->data->search_project = new Project();
    $this->data->search_project->set($criteria); 
  } 

  function show($params) {
    $params['id']
      ? $this->data->project = new Project($params['id'])
      : Bail('Required parameter $params["id"] missing.');
            
    $this->data->new_estimate = new Estimate();
    $this->data->new_estimate->set(array('project_id' => $params['id']));

    $this->data->new_hour = new Hour();
    $this->data->new_hour->set(array(
      'staff_id' => Session::getUserId(), 
      'date' => date('Y-m-d')
    ));
  }

  function create() {
    $p = $this->new_projects[0];
    $p->save();
    $this->redirectTo(array('controller' => 'Project', 'action' => 'show', 'id' => $p->id));
  }

  function new_form() {
    $this->data= new Project();
    $this->data->set(array('staff_id' => Session::getUserId()));
  }

  function update() {
    $p = $this->updated_projects[0];
    $p->save();
    $this->redirectTo(array('controller' => 'Project', 'action' => 'show', 'id' => $p->id));
  }

  function new_record() {}

  function destroy() {}

}

?>
