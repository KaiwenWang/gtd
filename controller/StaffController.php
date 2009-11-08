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
		$this->data->project = new Project();
		$this->data->project->set(array(
								'staff_id'=>getUser()
								)
							);
    }    
}
?>