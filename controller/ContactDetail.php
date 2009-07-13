<?php

/**
  	ContactDetail
    
    Displays details about a particular contact
   
   $params options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package controller

*/

class ContactDetail extends PageController {
    var $_class_name = 'ContactDetail';

    function __construct(){
        parent::__construct();
    }
    function get( $params = array()){
        $r =& getRenderer();
		if( !$params['contact_id']) {
			$r->msg('bad','you need a contact_id');
			return;
		}
        $contact = new contact($params['contact_id']);
        $html = $r->view('contactDetail', $contact);
          
        return $r->template('template/standard_inside.html',
                    array(
                    'title' => 'Viewing Details for '.$contact->getName(),
                    'controls' => '',
                    'body' => $html
                    ));
    }        
}
?>
