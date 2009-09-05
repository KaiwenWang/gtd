<?php
class ProjectController extends PageController {

    function __construct(){
        parent::__construct();
    }
    function index( $params){
		$d = $this->data;
		
		$project_search_criteria = array('sort' => 'custom17,custom4'); #status,launch_date

		if ( $params['staff_id']) {

			$d->staff = new Staff( $params['staff_id']);			
			$project_search_criteria['staff_id'] = $d->staff->id;			
			$d->staff_selected_value = $d->staff->id;

		} else {
		
			$d->staff_selected_value = false;
		
		}

        $d->projects = getMany( 'Project', $project_search_criteria); 
	}
	function show( $params){
		$params['id']	? $this->data->project = new Project( $params['id'])
						: Bail('required parameter $params["id"] missing.');
	}
}
?>
