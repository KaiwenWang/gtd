<?php
class ContactController extends PageController {
    
    function index( $params){
        $this->data->contacts = getAll( 'Contact');
    }
    
    function show( $params){
		if( !$params['id'] )	$bail('required param["id"] not set');
		
        $this->data->contact = new Contact($params['id']);
    }
}
?>
