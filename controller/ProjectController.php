<?php
class ProjectController extends PageController {
 	protected $before_filters = array( 'get_posted_records' => array('create','update','destroy'));

    function index( $params){
		$d = $this->data;
		
		$project_search_criteria = array('sort' => 'custom17 DESC,custom4'); #status,launch_date
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
	//added by margot -- get code help from ted why does the not actually add the project to the the company???
	function create( $params){
        $p = $this->new_projects[0];
    	$p->save();
    	$this->redirectTo( array('controller'=>'Company','action' => 'show','id' => $params['company_id']));
    }
    function new_record(){
    }
    function destroy(){
    }

}
?>
