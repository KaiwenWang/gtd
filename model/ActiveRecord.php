<?php
class ActiveRecord  extends Record {
    var $name_field;

    protected static $schema;
	protected static $schema_json;	

    function getData( $column_name = null){
   		return $this->get( $column_name);
    }
   function getName(){
		return $this->getData($this->name_field);
	}
	static function getOne( $search_criteria){
		return getOne( get_called_class(), $search_criteria);
	}
	static function getMany( $search_criteria){
		return getMany( get_called_class(), $search_criteria);
	}
	static function getAll(){
		return getAll( get_called_class());
	}
	function getArray( $search_criteria){
		$name = get_class($this);
		$obj = new $name;
		return $obj->find( $search_criteria);
	}
	function getFieldType( $field){
		$s = $this::_getSchema();
		if ( !array_key_exists( $field, $s['fields'])) bail("db field '$field' does not exist in schema file.");
		if ( !$s['fields'][$field]) bail( "db field '$field' exists in schema file, but does not have it's type set");
		if ( !empty($s['values']) && !empty($s['values'][$field])) return $s['values'][$field];
		return $s['fields'][$field];
	} 
	public static function _getSchema($class=''){
		$class = get_called_class();
		if ( !isset( $class::$schema)) {
			$r =& getRenderer();
			$class::$schema = $r->jsonDecode( $class::$schema_json);
        }
	    return $class::$schema;
	}
	function defaultSearchCriteria( $field_name){}

	function makeCriteriaDateRange( $data ) {
		$field_name = isset($data['field_name']) ? $data['field_name'] : 'date';
		if(isset($data['start_date']) && isset($data['end_date'])
			&& $data['start_date'] && $data['end_date'] ) {
				return "$field_name >= " . $this->dbcon->qstr($data['start_date'])
						. " AND $field_name <= " . $this->dbcon->qstr($data['end_date']);
		} elseif(isset($data['start_date']) && $data['start_date'] ) {
				return "$field_name >= " . $this->dbcon->qstr($data['start_date']);

		} elseif(isset($data['end_date']) && $data['end_date'] ) {
				return "$field_name <= " . $this->dbcon->qstr($data['end_date']);
		}
		return;
	}

    function _makeCriteriaMultiple($fieldname, $values) {
        if(empty($values)) return;
        if(is_array($values)) {
            return "$fieldname IN (". implode(",", $values). ")";
        }
        return "$fieldnamme = " . $this->dbcon->qstr( $values );
    }

    function isValid() {
        //stub
        return true;
    }
	
	function destroyAssociatedRecords(){
		// overwrite in subclass
	}
}
