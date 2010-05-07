<?php
class ContactController extends PageController {
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy')
 								);
    
    function index( $params){
        $this->data->contacts = getAll( 'Contact');
    }
    function show( $params){
		if( !$params['id'] )	$bail('required param["id"] not set');
		
        $this->data->contact = new Contact($params['id']);
    }
	function update( $params){
		$c = $this->updated_contacts[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company',
    							 'action' => 'show',
    							 'id'=>$c->getCompany()->id
    							 ));
	}
	function create( $params){
		$c = $this->new_contacts[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company',
    							 'action' => 'show',
    							 'id'=>$c->getCompany()->id
    							 ));
    }
}
?>
