<?php
class StaffController extends PageController {
	public $template = 'gtd_main_template';
 	var $before_filters = array( 'get_posted_records' => array( 'create','update','destroy'));

	function index(){
        $this->data->staff = getAll( 'Staff');
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
		if( !$params['id']) bail('can has Staff id? kthx');

		$this->data->active_projects = getMany('Project',array('active'=>true));

        $staff = new Staff($params['id']);
        $this->data->staff = $staff; 

		$hours_criteria = array('current_month'=>true);
		$this->data->hours_this_month = $staff->getHoursTotal($hours_criteria);
		$this->data->billable_hours_this_month = $staff->getBillableHoursTotal($hours_criteria);

		$hours_criteria = array('current_week'=>true);
		$this->data->hours_this_week = $staff->getHoursTotal($hours_criteria);
		$this->data->billable_hours_this_week = $staff->getBillableHoursTotal($hours_criteria);

		$this->data->new_project = new Project();
		$this->data->new_project->set(array(
								'staff_id'=>getUser()
								)
							);

		$this->data->new_support_hour = new Hour();
		$this->data->new_support_hour->set(array(
								'staff_id'=>getUser(),
								'date'=>date('Y-m-d')
								)
							);
    }
}
