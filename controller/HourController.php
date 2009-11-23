<?php
class HourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	
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
		$h = $this->new_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'Estimate', 
        						'action' => 'edit', 
        						'id' => $h->get('estimate_id')
        						));
    }
    function destroy(){
    }
}
?>