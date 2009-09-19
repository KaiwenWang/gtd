<?php
class EstimateController extends PageController {

    function __construct(){
        parent::__construct();
    }
    function edit( $params){
		$d = $this->data;
		
		$d->estimate = new Estimate( $params['id']);
		$d->project = new Project( $d->estimate->get('project_id'));
    }
    function update( $params ){
//    	bail(AMP_dump( $params));
    	$estimates = $params['ActiveRecord']['Estimate'];
    	foreach( $estimates as $estimate_id => $estimate_data){
	    	$e = new Estimate( $estimate_id);
    		$e->mergeData( $estimate_data);
    		$e->save();
    	}
	    $this->redirectTo( array('action' => 'edit','id'=>$e->id));
    }
    function create( $params){
    	$e = new Estimate();
    	$data = $params['ActiveRecord']['Estimate']['new'];
    	$e->mergeData( $data);
    	$e->save();
    	$this->redirectTo( array('controller'=>'Project','action' => 'show','id'=>$e->get('project_id')));
    }
    function new_record(){
    }
    function destroy(){
    }
}
?>
