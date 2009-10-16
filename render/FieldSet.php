<?php
class FieldSet {
	var $new_object_counter;
	var $obj;
	var $is_new_object;
	
	function __construct( $obj, $new_object_counter = ''){
		$this->obj = $obj;
		$obj->id	? $this->is_new_object = false
					: $this->is_new_object = true;
					
		$this->new_object_counter = $new_object_counter;
	}
	function __get( $field_name) {
		$r = getRenderer();
		if( $this->is_new_object) 	return $r->field( $this->obj, 
													  $field_name, array(),
													  $this->new_object_counter);
		else 					 	return $r->field( $this->obj, $field_name);
	}
}
?>