<?php
class ProjectController extends PageController {
 	protected $before_filters = array( 'get_posted_records' => array('create','update','destroy'));

    function index( $params){
		$d = $this->data;
				
		$project_search_criteria = array('sort' => 'status DESC, launch_date'); #status,launch_date
        $d->projects = getMany( 'Project', $project_search_criteria);
        $d->new_project = new Project();
	    $d->new_project->setData(array('staff_id'=>getUser()));
	}
	function show( $params){
		$params['id']	? $this->data->project = new Project( $params['id'])
						: Bail('required parameter $params["id"] missing.');			
		$e = new Estimate();
		$e->set(array('project_id'=>$params['id']));
		$this->data->estimate = $e;
		$this->data->hour = new Hour();
		$this->data->hour->set(array(
								'estimate_id'=>$e->id,
								'staff_id'=>getUser()
								)
							);
	}
	//added by margot -- get code help from ted why does the not actually add the project to the the company???
	function create(){
        $p = $this->new_projects[0];
        $p->save();
    	$this->redirectTo( array('controller'=>'Project','action' => 'show','id' => $p->id));
    }
    function update(){
    	$p = $this->updated_projects[0];
    	$p->save();
    	$this->redirectTo( array('controller'=>'Project','action' => 'show','id' => $p->id));
    }
    function new_record(){
    }
    function destroy(){
    }

}
?>
