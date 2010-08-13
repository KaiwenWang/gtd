<?php
class StaffController extends PageController {

    function index(){
        $this->data->staff = getAll( 'Staff');
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
?>
