<?php
class EstimateController extends PageController {
 	protected $before_filters = array( 'get_posted_records' => array('create','update','destroy'));
 	
    function edit( $params){
		$d = $this->data;
		
		$d->estimate = new Estimate( $params['id']);
		$d->project = new Project( $d->estimate->get('project_id'));
		$d->hours = getMany('Hour', array("estimate_id"=>$params['id']));
    }
    function update( $params ){
    	foreach( $this->updated_estimates as $e) $e->save();
	    $this->redirectTo( array('action' => 'edit','id'=>$e->id));
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
?>
