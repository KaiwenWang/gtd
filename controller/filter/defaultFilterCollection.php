<?php
class defaultFilterCollection {
	var $controller;
	
    protected function get_posted_records( ){
    	$record_set = $this->controller->params['ActiveRecord'];
			foreach( $record_set as $class_name => $object_set){
				foreach( $object_set as $id => $updated_fields){
					if( $id == 'new') bail('Can\'t create new objects yet');
					$obj = new $class_name( $id);
					$obj->mergeData( $updated_fields);
					
					$this->controller->posted_records[]=$obj;
				}
			}
    }

    protected function save_posted_records( ){
			foreach( $this->controller->posted_records as $obj) $obj->save();
			if( $this->controller->params('redirect')) {
				header('Location: '.$this->params('redirect').'');
				die();
			}
    }
}
?>