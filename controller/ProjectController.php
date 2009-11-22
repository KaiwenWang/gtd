<?php
class ProjectController extends PageController {
 	protected $before_filters = array( 'get_posted_records' => array('create','update','destroy'));

    function index( $params){
		$d = $this->data;
				
        $d->projects = getMany( 'Project', array('sort' => 'status DESC, launch_date'));

        $d->new_project = new Project();
	    $d->new_project->set(array('staff_id'=>getUser()));
	}
	function show( $params){
		$params['id']	? $this->data->project = new Project( $params['id'])
						: Bail('required parameter $params["id"] missing.');
						
		$this->data->estimate = new Estimate();
		$this->data->estimate->set(array('project_id'=>$params['id']));

		$this->data->hour = new Hour();
		$this->data->hour->set(array(
								'estimate_id'=>$e->id,
								'staff_id'=>getUser()
								)
							);
	}
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
