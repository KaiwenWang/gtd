<?php
class PageController {
    var $authentication_level = array( 'staff');
    var $_class_name = 'PageController';
    
    function PageController() {
        $this->__construct();
    }
    function __construct(){
        
    } function execute( $action, $params = array()){
    	if ( $action == 'get'){
    		return $this->get( $params);				
    	} else if ( $action == 'post'){
    		$this->beforePost();
    		$this->post();
    		$this->afterPost();
    	} else {
    		trigger_error( 'invalid or blank action requested: '.$action);
    	}
    }
    function get( $params = array()){
		// MUST be defined in a subclass
    }
    function beforePost( ){}
    function post( $params = array()){
		// MUST be defined in a subclass        
    }
    function afterPost( ){}
}
?>