<?php
class ActiveRecord  extends AMPSystem_Data_Item {
	var $_class_name = "ActiveRecord";
	var $name_field;
	var $db_fields = array();
	
	function __construct( $id = null){
        parent::__construct( getDbcon(), $id);
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
		$field_type = $this->db_fields[ $field];
		if (!$field_type) bail(" No field of type $field available on ".$this->_class_name.' Object');
		if ( strchr( ',', $field_type)) return str_getcsv( $field_type);
		return $field_type;
	} 
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
