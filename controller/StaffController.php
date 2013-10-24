<?php
class StaffController extends PageController {
  public $template = 'gtd_main_template';
   var $before_filters = array( 'get_posted_records' => array( 'create','update','destroy'));

  function index(){
        $this->data->staff = getAll( 'Staff');
  }

  function edit($params) {
      if(!isset($params['id'])) bail("must haz id to show you that!");
      $this->data->staff = new Staff($params['id']);
  }

  function update($params){
    $staff = $this->updated_staffs[0];
    if( !empty($params['new_password'])){
      Render::msg('Password Changed');
      $staff->setPassword($params['new_password']);
    }
    $staff->save();
    $this->redirectTo( array('controller'=>'Staff',
                 'action'=>'show',
                 'id'=>$staff->id
                 ));
  }

  function show( $params = array()){
    if(!isset($params['id']) || !$params['id']) {
      $staff_members = getAll( 'Staff');
      foreach($staff_members as $staff) {
        if(!$staff->get('active') || (($staff->get('team') != 'Production') && ($staff->get('team') != 'Development')))  {
          continue;
        }
        if(!isset($this->data->billable_hours_this_week)) {
          $this->data->staff = array();
          $this->data->billable_hours_this_week = array();
        }
        $hours_criteria = array('current_week'=>true);
        $this->data->staff[$staff->get('id')] = $staff->getName();
        $this->data->billable_hours_this_week[$staff->get('id')] = $staff->getBillableHoursTotal($hours_criteria);
        
      }
      
    } else {

      $this->data->active_projects = getMany('Project',array('active'=>true));

      $staff = new Staff($params['id']);
      $this->data->staff = $staff; 
      $this->data->staff_hours = $staff->getHours(); 

      $hours_criteria = array('current_month'=>true);
      $this->data->hours_this_month = $staff->getHoursTotal($hours_criteria);
      $this->data->billable_hours_this_month = $staff->getBillableHoursTotal($hours_criteria);

      $hours_criteria = array('current_week'=>true);
      $this->data->hours_this_week = $staff->getHoursTotal($hours_criteria);
      $this->data->billable_hours_this_week = $staff->getBillableHoursTotal($hours_criteria);

      $this->data->new_project = new Project();
      $this->data->new_project->set(array(
                  'staff_id'=>Session::getUserId()
                  )
                );

      $this->data->new_support_hour = new Hour();
      $this->data->new_support_hour->set(array(
                  'staff_id'=>Session::getUserId(),
                  'date'=>date('Y-m-d')
                  )
                );
      $this->data->graph = Array(
        'staff' => $staff->id,
        'call' => 'overview'
        );
    }
  }
    
}
