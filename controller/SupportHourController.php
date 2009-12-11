<?php
class SupportHourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	
    function index( $params ){
    
    }
    function show( $params ){
		if ( !$params['id']) bail('Required $params["id"] not present.');

    	$d = $this->data;

        $d->hour = new Hour( $params['id']);
	    $d->support_contract = new SupportContract( $d->hour->get('support_contract_id'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'support_contract_id'=>$params['id'],
								  'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
								  
		$d->new_support_contract = new SupportContract();
    }
    function update( $params ){
    	$h = $this->updated_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'SupportContract', 
        						'action' => 'show', 
        						'id' => $h->get('support_contract_id')
        						));
    }
    function new_record(){
    }
    function create( $params){
		$h = $this->new_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'SupportContract', 
        						'action' => 'show', 
        						'id' => $h->get('support_contract_id')
        						));
    }
    function destroy(){
    }
}
