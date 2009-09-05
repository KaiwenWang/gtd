<?php
/**
    ContactList
    
    Displays a list of all the contacts in the system. Doesn't yet take any options but we will add sort and search later.
              
    @return html
    @package controller
*/

class ContactController extends PageController {

    function __construct(){
        parent::__construct();
    }
    
    function index( $params){
        $this->data->contacts = getAll( 'Contact');
    }
    
    function show( $params){
		if( !$params['id'] )	$bail('required param["id"] not set');
		
        $this->data->contact = new Contact($params['id']);
    }
}
?>
