<?php
class HourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	var $after_filters = array( 'save_posted_records' => array('create','update','destroy') );
	
    function __construct(){
        parent::__construct();
    }
    function index( $params ){
    
    }
    function edit( $params ){
		if ( !$params['id']) bail('Required $params["id"] not present.');
    	$d = $this->data;
        $d->hour = new Hour( $params['id']);
	    $d->estimate = new Estimate( $d->hour->get('estimate_id'));
        $d->project = new Project( $d->estimate->get('project_id'));
    }
    function update( $params ){
	    $this->redirectTo( array('action' => 'edit','id'=>$params['id']));
    }
    function show(){
    }
    function new_record(){
    }
    function create( $params){
     	$e = new Hour();
    	$data = $params['ActiveRecord']['Hour']['new'];
    	$e->mergeData( $data);
    	$e->save();
        $this->redirectTo(array('controller' => 'Project', 'action' => 'show', 'id' => $params['project_id']));
    }
    function destroy(){
    }
}
?>