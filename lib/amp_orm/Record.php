<?php

/* * * * * * * * *
 *
 *  AMPSystem_Data_Item
 *
 *  A base class for retrieving and changing
 *  a single Database record
 *
 *  AMP 3.5.0
 *  2005-07-04
 *  Author: austin@radicaldesigns.org
 *
 * * * * * **/
require('utility.php');

class Record extends Data {

    var $dbcon;

    var $itemdata = array( );
    var $_itemdata_keys;
    var $_allowed_keys = array();

    var $id;
    var $_class_name;

    var $_sort_property;
    var $_sort_direction = 'asc';
    var $_sort_method = "";
    var $_sort_auto = true;

    var $_observers = array( );

    var $_collection;
    var $_search_criteria_global = array( );

    var $_field_status = 'publish';
    var $_field_listorder = 'listorder';

    var $_exact_value_fields = array( );
    var $_allow_db_cache = true;

    //flag for actions based on whether a bulk request is being executed
    var $list_action;

    function __construct( $item_id = null ) {
        $this->dbcon = AMP::getDb();
        $this->setSource( $this->datatable );
        if (isset($item_id) && $item_id) $this->readData( $item_id );
    }
    function read( $item_id ) {
        return $this->readData( $item_id );
    }

    function setSource( $sourcename ) {
        parent::setSource( $sourcename );
        $this->_itemdata_keys = $this->_getColumnNames( $this->datatable );
        $this->_allowed_keys = $this->_itemdata_keys;
    }

	function _addAllowedKey( $key_name ) {
		if (array_search( $key_name, $this->_allowed_keys )!==FALSE) return true;
		$this->_allowed_keys[] = $key_name;
	}

    function getAllowedKeys( ) {
        return $this->_allowed_keys;
    }

    function dropID( ){
        unset ( $this->_itemdata_keys[ $this->id_field ] );
        unset ( $this->id );
    }

    function addCriteriaId( $item_id ){
        $this->addCriteria( $this->id_field." = ".$this->dbcon->qstr( $item_id ) );
    }

    function addCriteriaGlobal( $criteria ){
        $this->_search_criteria_global = array_merge( $this->_search_criteria_global, $criteria );
    }

    function readData ( $item_id ) {
        if ( $item_id !== FALSE ) $this->addCriteriaId( $item_id );

        $sql = $this->_assembleSQL();

        AMP::debug_sql($sql, get_class($this));

        if ( $itemdata = $this->dbcon->CacheGetRow( $sql )) {
            $this->set_data_from_db($itemdata);
            return true;
        }

        if ($this->dbcon->ErrorMsg() ) 
            trigger_error ( sprintf( AMP_TEXT_ERROR_DATABASE_READ_FAILED, get_class( $this ) , $this->dbcon->ErrorMsg() ));
        return false;
    }

    function set_data_from_db($data) {
      $this->itemdata = $data;
      $this->id = $data[ $this->id_field ];
    }

    function hasData() {
        return (isset( $this->itemdata) && !empty($this->itemdata));
    }

    function deleteById( $item_id ) {
        return $this->deleteData( $item_id );
    }

    function deleteByCriteria( $criteria ) {
        $sql_criteria_set = $this->makeCriteria( $criteria );
        if ( !$sql_criteria_set || empty( $sql_criteria_set ) ) {
            return false;
        }
        $sql_criteria = ' WHERE ' . join( " AND ", $sql_criteria_set ) ;
        $sql = "Delete from " . $this->datatable . $sql_criteria;
        if ( ( $itemdata = $this->dbcon->Execute( $sql )) && $this->dbcon->Affected_Rows( )) {
            return true;
        }
        
        trigger_error ( AMP_TEXT_DELETE . ' ' . sprintf( AMP_TEXT_ERROR_DATABASE_SAVE_FAILED, get_class( $this ), $this->dbcon->ErrorMsg() . ' // ' . $sql  ));
        return false ;
    }

    function deleteData( $item_id ) {
        $sql = "Delete from " . $this->datatable . " where ". $this->id_field ." = ". $this->dbcon->qstr( $item_id );
        if ( ( $itemdata = $this->dbcon->Execute( $sql )) && $this->dbcon->Affected_Rows( )) {
            $cached_sql = $this->_assembleSqlByID( $item_id );
            $this->dbcon->CacheFlush( $cached_sql ) ;
            AMP::debug_sql($sql, get_class($this)." cleared cache");
            return true;
        } 

        trigger_error ( AMP_TEXT_DELETE . sprintf( AMP_TEXT_ERROR_DATABASE_SAVE_FAILED, get_class( $this ), $this->dbcon->ErrorMsg() ));
        return false ;
    }

    function delete( ){
        if ( !isset( $this->id )) return false;
        $this->before_delete( );
        if ( !$this->deleteData( $this->id )) return false;

        return true;
        
    }

    function _assembleSqlByID( $id ) {
         return $this->_makeSelect().
                $this->_makeSource().
                " WHERE ".$this->id_field." = ". $this->dbcon->qstr( $id );
    }

    function save() {
        $item_data = $this->get( );
        $save_fields = AMP::array_filter_by_keys($this->_itemdata_keys, $item_data );
		if ( !is_array( $this->id_field ) && !isset( $save_fields[ $this->id_field ] )) {
            $save_fields[ $this->id_field ] = "";
#            $this->_blankIdAction();
        }

        $result = $this->dbcon->Replace( $this->datatable, $save_fields, $this->id_field, $quote=true);

		bail(dump($result));

        if ($result == ADODB_REPLACE_INSERTED ) {
            $this->set( array( $this->id_field => $this->dbcon->Insert_ID() ));
        }
        
        if ($result) {
            $this->clearItemCache( $this->id );
            return true;
        }
        $this->addError( sprintf( AMP_TEXT_ERROR_DATABASE_SAVE_FAILED, get_class( $this ), AMP_TEXT_ERROR_DATABASE_PROBLEM ) );
        trigger_error ( sprintf( AMP_TEXT_ERROR_DATABASE_SAVE_FAILED, get_class( $this ), $this->dbcon->ErrorMsg()  ));

        return false;
    }

    function clearItemCache( $id ) {
        $sql = $this->_assembleSqlByID( $id );
        $this->dbcon->CacheFlush( $sql );
        AMP::debug_sql($sql, get_class($this)." cleared cache");
        $data_set = &$this->getCollection( );
        $data_set->clearCache( );
    }

    function clear_cache( ){
        if ( isset( $this->id )) {
            return $this->clearItemCache( $this->id );
        }
    }

    function mergeData( $data ) {
        $this->set($data);
    }

    function setData( $data ) {
      $this->set( $data );
    }
    
    function set( $fields){
        if(!$this->itemdata) $this->itemdata= array();
        $this->itemdata = array_merge( $this->itemdata, AMP::array_filter_by_keys( $this->_allowed_keys, $fields));
#        if (method_exists( $this, '_adjustSetData' ) ) $this->_adjustSetData( $data );
        if (isset($data[$this->id_field]) && $data[$this->id_field]) $this->id = $data[$this->id_field];
    }

    function get( $fieldname = null ) {
        if (!isset($fieldname)) return $this->itemdata;
        if (isset($this->itemdata[$fieldname])) return $this->itemdata[$fieldname];

        return false;
    }

    function getName() {
        if (!isset($this->name_field)) return;
        return $this->get( $this->name_field );
    }

    function legacyFieldname( $data, $oldname, $newname ) {
        if (isset($data[$oldname])) $this->itemdata[$newname] = $data[$oldname];
        if (isset($data[$newname])) {
            $this->itemdata[$newname] = $data[$newname];
            $this->itemdata[$oldname] = $data[$newname];
        }
		$this->_addAllowedKey($newname);
    }

   /**
     * Search methods
     * 
     * @param mixed $criteria 
     * @param mixed $class_name 
     * @access public
     * @return void
     */
    function find( $criteria = null ) {
        $class_name = get_class($this);

        $collection = $this->getCollection( $this->makeCriteria( $criteria ));
        $collection->setSortAndLimit( $criteria );
       
        if ( !$collection->readData( )) return false;

        $objects = $collection->instantiateItems( $collection->getArray( ), $class_name );
        if ( empty( $objects )) return $objects;
        if ( $this->_sort_auto && !$collection->getSort( )) $this->sort( $objects );

        return $objects;
    }
     

    function getCollection( $criteria = null ){
        if ( isset( $this->_collection ) && $this->_collection ) {
            if ( !isset( $criteria )) return $this->_collection;
            $collection = &$this->_collection;
        } else {
            $collection = &new RecordCollection( $this->dbcon );
            $collection->setSource( $this->datatable );
        }
        if ( isset( $criteria )) {
            $collection->setCriteria( $criteria );
        }
        foreach( $this->_search_criteria_global as $crit_phrase ){
            $collection->addCriteria( $crit_phrase );
        }
        if ( !$this->_allow_db_cache ) $collection->clearCache( );
        
        $this->_collection = &$collection;
        return $this->_collection;

    }

    //}}}

    //{{{ Sorting methods: sort, setSortMethod, _sort_default

    function sort( &$item_set, $sort_property=null, $sort_direction = null ){
        if ( !( isset( $sort_property) && $sort_property )) {
            $this->_sort_default( $item_set );
            return true;
        }

        if ( !$this->setSortMethod( $sort_property )) {
            trigger_error( sprintf( AMP_TEXT_ERROR_SORT_PROPERTY_FAILED, $sort_property, get_class( $this )));
            return false;
        }

        if ( isset( $sort_direction ))  $this->_sort_direction = $sort_direction;

        uasort( $item_set, array( $this, '_sort_compare' ));
        return true;
    }
    function _sort_compare( $file1, $file2 ) {
        if ( !( $sort_method = $this->_sort_accessor )) return 0;

        if ( !is_object( $file2)) {
            return 0;
        }

        //sort descending
/*
        if ( $this->_sort_direction == AMP_SORT_DESC ) {
            return strnatcasecmp( $file2->$sort_method( ) , 
                                    $file1->$sort_method( ) ); 
        }
*/
        //sort ascending
        return strnatcasecmp( $file1->$sort_method( ) , $file2->$sort_method( ) );
    }

    function setSortMethod( $sort_property ) {
        $access_method = 'get' . AMP::camelcase( $sort_property );
        if ( !method_exists( $this, $access_method )) return false;
        $this->_sort_accessor = $access_method;
        return true;
    }

    function _sort_default( &$item_set ){
        return $this->sort( $item_set, 'name');
    }
    //}}}

    //{{{ Object based Search methods: makeCriteria

    /**
     * makeCriteria 
     * 
     * @param mixed $data 
     * @access public
     * @return void
     */
    function makeCriteria( $data ){
        $return = array( );
        if ( !( isset( $data ) && is_array( $data ))) return false;
        foreach ($data as $key => $value) {
            $crit_method1 = 'makeCriteria' . ucfirst( $key );
            $crit_method2 = 'makeCriteria' . AMP::camelcase( $key );
            $crit_method = ( method_exists( $this, $crit_method1)) ? $crit_method1 : $crit_method2;

            if (method_exists( $this, $crit_method )) {
                $return[$key] = $this->$crit_method( $value );
                continue;
            }
            if ( $crit_method = $this->_getCriteriaMethod( $key, $value )){
                $return[$key] = $this->$crit_method( $key, $value );
            }

        }
        return array_filter( $return );
    }
    function _getCriteriaMethod( $fieldname, $value  ) {
        if ( !$this->isColumn( $fieldname )) return false;
        if (array_search( $fieldname, $this->_exact_value_fields ) !==FALSE) return '_makeCriteriaEquals';
        if ( is_numeric( $value )) return '_makeCriteriaEquals';
        return '_makeCriteriaContains';
    }

    function _makeCriteriaContains( $key, $value ) {
        return $key . ' LIKE ' . $this->dbcon->qstr( '%' . $value . '%' );
    }

    function _makeCriteriaEquals( $key, $value ) {
        return $key . ' = ' . $this->dbcon->qstr( $value );
    }
    
    function makeCriteriaId( $value ) {
        if ( !$value ) return 'TRUE';
        if ( !is_array( $value )) return $this->_makeCriteriaEquals( 'id', $value );
        return 'id in ( '.join( ',', $value).')';
    }

    function makeCriteriaNotId( $ids ) {
        if ( !$ids ) return "TRUE";
        if ( !( is_array( $ids ))) return 'id != '.$ids;
        return "id not in ( " . join(",", $ids ) . ")";
    }

    function create( $attributes = array( ), $class_name = null ) {
        if( !$class_name ) {
            $context = debug_backtrace( );
            trigger_error( 'class name not included for call to '.__FUNCTION__.' on '.$debug_backtrace[0]['class']);
            return false;
        }

        $item = new $class_name( AMP::getDb( ));
        $item->mergeData( $attributes );
        return $item;
    }


    function update_all( $action, $criteria = array( )){
        if( !is_array( $action )) {
            $action = array( $action );
        }
        $search = &$this->getCollection( );

        if( is_array( $criteria )) {
            $scope = join( ' AND ', $this->makeCriteria( $criteria )) ;
        } else {
            $scope = $criteria;
        }

        return $search->updateData( $action, $scope );
    }


}
?>
