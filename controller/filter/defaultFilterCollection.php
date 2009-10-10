<?php
class defaultFilterCollection {
	var $controller;
	function __construct( $controller ){
    	$this->controller = $controller;
	}
    protected function get_posted_records( ){
    	trigger_error('get_posted_records starting');
    	$record_set = $this->controller->params['ActiveRecord'];
			foreach( $record_set as $class_name => $object_set){
				foreach( $object_set as $id => $updated_fields){
					preg_match( '/new-.*/', $id) ?	$obj = new $class_name();
												 :	$obj = new $class_name( $id);
												 
					$obj->mergeData( $updated_fields);
					
					$this->controller->posted_records[]=$obj;
				}
			}
    }
    protected function save_posted_records( ){
    	trigger_error('save_posted_records starting');
		foreach( $this->controller->posted_records as $obj) $obj->save();
	}
}
?>