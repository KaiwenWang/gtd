<?php
/**
Bastard

some description of Bastard, and that thing he do.

package @controller
*/
class Bastard extends PageController {
    var $_class_name = 'Bastard';
    
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
		$r =& getRenderer();
		
        $html = $r->view('testView', $view_data, array('class'=>'test'));
    }
	function post( $post = array()){
	}
}
?>
