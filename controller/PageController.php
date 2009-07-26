<?php
class PageController {
    var $authentication_level = array( 'staff');
    var $_class_name = 'PageController';
    var $params = array();
    var $posted_objects = array();
    var $response;
    
    function __construct(){
        
    } 
    function execute( $action, $params = array()){
        $this->params = $params;
    	if ( method_exists( $this, $action)){
			$beforeAction = 'before'.ucfirst( $action);
	   		$afterAction = 'after'.ucfirst( $action);
	    	if ( method_exists( $this, $beforeAction)) $this->$beforeAction();
    		$this->response = $this->$action( $this->params);
			if ( method_exists( $this, $afterAction)) $this->$afterAction();
			if ( $this->response) return $this->response;
			bail( 'No response from this action.');
    	} else {
    		bail( 'invalid or blank action requested: '.$action);
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
