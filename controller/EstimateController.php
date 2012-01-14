<?php
class EstimateController extends PageController {
	public $template = 'gtd_main_template';
 	protected $before_filters = array( 'get_posted_records' => array('create','update','destroy'));
 	
    function show( $params){
   		if ( !$params['id']) bail('Required $params["id"] not present.');
		$d = $this->data;
		
		$d->estimate = new Estimate( $params['id']);

		$d->project = new Project( $d->estimate->get('project_id'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'estimate_id'=>$params['id'],
								  'staff_id'=>Session::getUserId(),
								  'date'=>date('Y-m-d')
								  ));

		$d->new_estimate = new Estimate();
		$d->new_estimate->set(array('project_id'=>$d->project->id));
		
		$d->estimates = $d->project->getEstimates();

		$d->hours = getMany('Hour', array('estimate_id'=>$params['id'], 'sort'=>'date DESC'));
    }
    function update( $params ){
    	foreach( $this->updated_estimates as $e) $e->save();
	    $this->redirectTo( array('controller'=>'project','action' => 'show','id'=>$e->get('project_id')));
    }
    function create( $params){
    	$e = $this->new_estimates[0];
    	$e->save();
    	$this->redirectTo( array('controller'=>'Project','action' => 'show','id'=>$e->get('project_id')));
    }
    function new_record(){
    }
    function destroy(){
    }
}
