<?php
class StaffController extends PageController {

    function index(){
        $this->data->staff = getAll( 'Staff');
    }
    function show( $params = array()){
		if( !$params['id']) {
			bail('can has Staff id? kthx');
		}

        $this->data->staff = new Staff($params['id']);
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
