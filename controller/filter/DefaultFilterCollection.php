<?php
class DefaultFilterCollection {
	var $controller;
	function __construct( $controller ){
    	$this->controller = $controller;
	}
	function get_search_criteria(){
		if(empty($this->controller->params['ActiveRecord'])) return;

    	$record_set = $this->controller->params['ActiveRecord'];
		foreach( $record_set as $class_name => $object_set){
			$search_criteria = array();
			foreach( $object_set as $id => $search_request){
				$search_criteria = array_merge( $search_criteria,
												$search_request);
			}
            $class_search_name = 'search_for_'.snake_case( pluralize( $class_name ));
			$this->controller->$class_search_name = $search_criteria;
		}
	}
    function get_posted_records( ){
    	$record_set = $this->controller->params['ActiveRecord'];
        if(!$record_set) return;
		foreach( $record_set as $class_name => $object_set){
			foreach( $object_set as $id => $updated_fields){
				if ( preg_match( '/new-.*/', $id) ){
					$obj = new $class_name();
					$action = 'new';
				} else {
					$obj = new $class_name( $id);
					$action = 'updated';
				}
											 
				$obj->mergeData( $updated_fields);
				
                $posted_record_collection = $action.'_'.snake_case( pluralize( $class_name ));
                if( !isset($this->controller->$posted_record_collection )) $this->controller->$posted_record_collection = array( );
				$this->controller->posted_records[$class_name][$action][] = $obj;
                $this->controller->{$posted_record_collection}[] = $obj;
			}
		}
    }
}
?>
