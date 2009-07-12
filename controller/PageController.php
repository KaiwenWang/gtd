<?php
class PageController {
    var $authentication_level = array( 'staff');
    var $_class_name = 'PageController';
    var $params = array();
    
    function __construct(){
        
    } 
    function execute( $action, $params = array()){
    	$this->params = $params;
    	if ( $action == 'get'){
    		return $this->get( $this->params);				
    	} else if ( $action == 'post'){
    		$this->beforePost();
    		$this->post( $this->params);
    		$this->afterPost();
    	} else {
    		trigger_error( 'invalid or blank action requested: '.$action);
    	}
    }
    function get( $params){
		// MUST be defined in a subclass
    }
    protected function beforePost( ){
    	
    }
    function post( $params){
		// MUST be defined in a subclass
    }
    protected function afterPost( ){}
}
?>