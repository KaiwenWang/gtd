<?php
class PageController {
    var $authentication_level = array( 'staff');
    var $_class_name = 'PageController';
    var $params = array();
    var $posted_objects = array();
    
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
    	$record_set = $this->params['ActiveRecord'];
		foreach($record_set as $class_name => $object_set){
			foreach( $object_set as $id => $updated_fields){
				if( $id == 'new') bail('Can\'t create new objects yet');
				$obj = new $class_name( $id);
				$obj->mergeData( $updated_fields);
				$this->posted_objects[]=$obj;
			}
		}
    }
    function post(){
		// MUST be defined in a subclass
    }
    protected function afterPost( ){
		foreach( $this->posted_objects as $obj) $obj->save();
		if( $this->params('redirect')) {
			header('Location: '.$this->params('redirect').'');
			die();
		}
    }
    protected function params( $key ){
        if( isset( $this->params[$key]) && $this->params[$key]) {
            return $this->params[$key];
        }
        return false;
    }
}
?>
