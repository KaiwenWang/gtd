<?php
class ActiveRecord  extends AMPSystem_Data_Item {
	var $_class_name = "ActiveRecord";
	var $name_field;
	protected static $schema;
	protected static $schema_json;	
	function __construct( $id = null){
        parent::__construct( getDbcon(), $id);
    }
    function get( $field){
    	return $this->getData( $field);
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
		return call_user_func( array(get_class($this), '_getSchema'));
	}
	public static function _getSchema(){
		if ( !isset( self::$schema)) {
			$r =& getRenderer();
            self::$schema = $r->jsonDecode( Hour::$schema_json);
        }
        return self::$schema; 
	}
	function defaultSearchCriteria( $field_name){}
    function &_getSearchSource( $criteria = null ){
        if ( isset( $this->_search_source ) && $this->_search_source ) {
            if ( !isset( $criteria )) return $this->_search_source;
            $data_set = &$this->_search_source;
        } else {
            require_once( 'Amp_Data_Set.php' );
            $data_set = &new Amp_Data_Set( $this->dbcon );
            $data_set->setSource( $this->datatable );
        }
        if ( isset( $criteria )) {
            $data_set->setCriteria( $criteria );
            /*
            foreach( $criteria as $crit_phrase ){
                $data_set->addCriteria( $crit_phrase );
            }
            */
        }
        foreach( $this->_search_criteria_global as $crit_phrase ){
            $data_set->addCriteria( $crit_phrase );
        }
        if ( !$this->_allow_db_cache ) $data_set->clearCache( );
        
        $this->_search_source = &$data_set;
        return $this->_search_source;

    }
}
?>