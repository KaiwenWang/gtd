<?php
class defaultFilterCollection {
	var $controller;
	function __construct( $controller ){
    	$this->controller = $controller;
	}
    function get_posted_records( ){
    	trigger_error('get_posted_records starting');
    	$record_set = $this->controller->params['ActiveRecord'];
		if(!$record_set) return;
		foreach( $record_set as $class_name => $object_set){
			foreach( $object_set as $id => $updated_fields){
				if ( preg_match( '/new-.*/', $id) ){
					$obj = new $class_name();
					$action = 'create';
				} else {
					$obj = new $class_name( $id);
					$action = 'update';
				}
											 
				$obj->mergeData( $updated_fields);
				
				$this->controller->posted_records[$class_name][$action][] = $obj;
			}
		}
    }
    function save_posted_records( ){
    	trigger_error('save_posted_records starting');
    	if (!$this->controller->posted_records) return;
		foreach( $this->controller->posted_records as $classes){
			foreach( $classes as $actions){
				foreach( $actions as $objects){
					$objects->save();
				}
			}
		}
	}
}
?>