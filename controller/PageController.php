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
    		$html = $this->get( $params);
    		return $r->form( 	'get', 
    							$this->_class_name, 
    							$html, 
    							array( 'load_results_to'=>$this->_class_name, 'class'=>'page-controller-form')
    						);
    						
    	} else if ( $action == 'post'){
    	
    	} else {
    		trigger_error( 'invalid or blank action requested: '.$action);
    	}
    }
    function get( $params = array()){
		// MUST be defined in a subclass
    }
    function post( $params = array()){
		// MUST be defined in a subclass        
    }
}
?>