<?php

/**
  	ContactDetail
    
    Displays details about a particular contact
   
   $get options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package controller

*/

class ContactDetail extends PageController {
    var $_class_name = 'ContactDetail';

    function ContactDetail() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
		if( !$get['contact_id']) {
			$r->msg('bad','you need a contact_id');
			return;
		}
        $contact = new contact($get['contact_id']);
        $html = $r->view('contactDetail', $contact);
          
        return $html;
    }        
}
?>
