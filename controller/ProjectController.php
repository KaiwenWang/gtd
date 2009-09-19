<?php
class ProjectController extends PageController {

    function __construct(){
        parent::__construct();
    }
    function index( $params){
		$d = $this->data;
		
		$project_search_criteria = array('sort' => 'custom17,custom4'); #status,launch_date
        $d->projects = getMany( 'Project', $project_search_criteria);
	}
	function show( $params){
		$params['id']	? $this->data->project = new Project( $params['id'])
						: Bail('required parameter $params["id"] missing.');
						
		$e = new Estimate();
		$e->set(array('project_id'=>$params['id']));
		$this->data->estimate = $e;

		$this->data->hour = new Hour();
		$this->data->hour->mergeData(array('estimate_id'=>$e->id));
	}
}
?>
