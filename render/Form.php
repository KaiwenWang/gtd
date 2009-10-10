<?php
class Form {
	var $new_object_counters = array();
	var $content;
	var $controller;
	var $action;
	var $method;
	
	function __construct( $o = array()){
		$this->controller = $o['controller'];
		$this->action = $o['action'];
		$this->method = $o['method'];
	}
	public function __set($key, $value) {
		$setter_method ='set'.ucfirst($key);
		
		if ( method_exists( $this, $setter_method)){
			return $this->$setter_method( $value);
		}
		$this->$key = $value;
	}
	public function __get($key) {
		$getter_method ='get'.ucfirst($key);
		
		if ( method_exists( $this, $getter_method)){
			return $this->$getter_method();
		}
		return $this->$key;
	}
	function getHtml(){
		$r = getRenderer();
		$html = $r->form( $this->action, 
						 $this->controller, 
						 $this->content.$r->submit(), 
						 array('method'=>$this->method)
						 );
		return $html;
	}
	function getFieldsFor( $obj){
		if( !is_a( $obj, 'ActiveRecord')) bail('Cannot get fields for non-ActiveRecord objects');

		$obj->id	? $fields = new FieldCollection( $obj)
					: $fields = new FieldCollection( $obj, $this->incrementNewObjectCounterFor( $obj));

		return $fields;
	}
	function incrementNewObjectCounterFor( $obj){
		$class = get_class( $obj);

		isset($this->new_object_counters[$class])	? $this->new_object_counters[$class]++
													: $this->new_object_counters[$class] = 0;

		return $this->new_object_counters[$class];
	}
}
?>