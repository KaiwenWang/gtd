<?php
class ActiveRecord  extends Record {
	var $_class_name = "ActiveRecord";
        var $name_field;

        protected static $schema;
	protected static $schema_json;	

        function getData( $column_name = null){
          return $this->get( $column_name);
        }
        function getName(){
		return $this->getData($this->name_field);
	}
	function getArray( $search_criteria){
		$name = $this->_class_name;
		$obj = new $name;
		return $obj->find( $search_criteria);
	}
	function getFieldType( $field){
		$s = $this->getSchema();
		if ( !array_key_exists( $field, $s['fields'])) bail("db field '$field' does not exist in schema file.");
		if ( !$s['fields'][$field]) bail( "db field '$field' exists in schema file, but does not have it's type set");
		return $s['fields'][$field];
	} 
	function getSchema(){
		$class = get_class($this);
		return call_user_func( array($class, '_getSchema'), $class);
	}
	public static function _getSchema($class){
		return	eval(
						'$r =& getRenderer();
	        	    	return $r->jsonDecode( '.$class.'::$schema_json);'
	        	    );
		/*
		Optimized, but only works in php 5.3.0+
		if ( !isset( $class::$schema)) {
		$r =& getRenderer();
	    $class::$schema = $r->jsonDecode( '.$class.'::$schema_json);
		}
		return $class::$schema;
		*/
	}
	function defaultSearchCriteria( $field_name){}
}
?>
