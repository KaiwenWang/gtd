<?php
/**
    ContactList
    
    Displays a list of all the contacts in the system. Doesn't yet take any options but we will add sort and search later.
              
    @return html
    @package controller
*/

class ContactList extends PageController {
    var $_class_name = 'ContactList';

    function ContactList() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r = getRenderer();
        $contacts = new Contact();
        $contacts = getAll( 'Contact');
        $html = $r->view('contactTable', $contacts, array('id'=>'Contact'));
        $name = 'Listing All Contacts';
        return $r->template('template/standard_inside.html',
                            array(
                            'title'=>$name,
                            'body'=>$html
                            ));
    }        
}
?>
