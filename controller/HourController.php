<?php
class HourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	
    function index( $params ){
    
    }
    function show( $params ){
		if ( !$params['id']) bail('Required $params["id"] not present.');

    	$d = $this->data;

        $d->hour = new Hour( $params['id']);
	    $d->estimate = new Estimate( $d->hour->get('estimate_id'));
        $d->project = new Project( $d->estimate->get('project_id'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'estimate_id'=>$params['id'],
								  'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
								  
		$d->new_estimate = new Estimate();
		$d->new_estimate->set(array('project_id'=>$d->project->id));
    }
    function update( $params ){
    	$h = $this->updated_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'Estimate', 
        						'action' => 'show', 
        						'id' => $h->get('estimate_id')
        						));
    }
    function new_record(){
    }
    function create( $params){
		$h = $this->new_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'Estimate', 
        						'action' => 'show', 
        						'id' => $h->get('estimate_id')
        						));
    }
    function destroy(){
    }
}
?>
