<?php
class RecordCollection extends Data {

    var $sort = array();
    var $limit;
    var $offset;
    var $_search_class = 'RecordSearch';
    var $_search_exact_values = array();
    var $_search_fulltext = array( );
    var $_id_field_lookups;
    
    var $source;

    //Data Management Functions

    function readData() {
        $sql = $this->_assembleSQL();
        AMP::debug_sql( $sql, get_class($this));
        if ($this->source = $this->dbcon->CacheExecute($sql)) {
            return true;
        }

        trigger_error ( sprintf( "SQL failed for %s %s Error: %s SQL: %s", get_class( $this ), 'read', $this->dbcon->ErrorMsg(), $sql ));
        return false;
        
    }

    function getData() {
        if (!$this->hasData()) return false;
        return $this->source->FetchRow();
    }

    function isReady() {
        return $this->makeReady();
    }

    function refreshData() {
        $this->clearCache( );
        $this->readData();
    }

    function clearCache( ){
        $cached_sql = $this->_assembleSQL( );
        $this->dbcon->CacheFlush( $cached_sql );
        AMP::debug_sql( $cached_sql, get_class($this). ' cleared cache');
    }

    function makeReady() {
        if (!$this->hasData()) return false;
        $this->source->MoveFirst();
        return true;
    }

    function setSort( $expression_set, $hold_priority = true ) {
        if (!(is_array($expression_set) || is_string($expression_set)) ) return false;
        $this->sort = array();

        if (is_string($expression_set)) return $this->addSort( $expression_set, false );
				/*
        if ($hold_priority) {
						$expression_set = array_reverse( $expression_set, true );
				}
				*/

        foreach ($expression_set as $exp) {
            $this->addSort ( $exp, false);
        }
    }

    function addSort ( $exp, $primary = true ) {
        if (!is_string($exp)) return false;
        if (array_search( $exp, $this->sort )!==FALSE) return true;

        if ($primary) return array_unshift( $this->sort, $exp );

        return ( $this->sort[] = $exp);
        return true;
    }

    function getSort() {
        if (empty($this->sort)) return false;
        reset ($this->sort);
        return current( $this->sort );
    }


    function _assembleSQL( $criteria = null ) {
        $sql  = $this->_makeSelect();
        $sql .= $this->_makeSource();
        $sql .= isset( $criteria ) ? 
                    ' WHERE ' . $criteria 
                    : $this->_makeCriteria();
        $sql .= $this->_makeSort();
        $sql .= $this->_makeLimit();
        return $sql;
    }

    function deleteData($criteria) {
        if (!$criteria) return false;
        $sql = "DELETE" . $this->_makeSource(). " where " . $criteria;
        if($this->dbcon->Execute($sql)) {
            AMP::debug_sql( $sql, get_class($this));

            $cached_sql = $this->_assembleSql( $criteria ) ;
            $this->dbcon->CacheFlush( $cached_sql );
            AMP::debug_sql( $sql, get_class($this). ' cleared cache');
            return $this->dbcon->Affected_Rows();
        }
        trigger_error ( sprintf( AMP_TEXT_ERROR_DATABASE_SQL_FAILED, get_class( $this ), 'delete', $this->dbcon->ErrorMsg(), $sql ));

        return false;
        
    }

    function updateData( $update_actions, $criteria = "1" ) {
        if (!is_array( $update_actions )) return false;
        $sql = "UPDATE " . $this->datatable . " SET " . join( ", ", $update_actions ) .
               " where " . $criteria;
        if ($this->dbcon->Execute($sql)) {
            AMP::debug_sql( $sql, get_class($this) . ' update');
            return $this->dbcon->Affected_Rows();
        }
        trigger_error ( sprintf( AMP_TEXT_ERROR_DATABASE_SQL_FAILED, get_class( $this ), 'update', $this->dbcon->ErrorMsg(), $sql ));
        return false;
    }

    function insertData( $values ){
        $source = new Record( $this->dbcon );
        $source->setSource( $this->datatable );
        $source->set( $values );
        $sql = $source->debug_insertSQL( );
        if ($this->dbcon->Execute($sql)) {
            AMP::debug_sql( $sql, get_class($this) . ' insert');
            return $this->dbcon->Affected_Rows();
        }

        trigger_error ( sprintf( AMP_TEXT_ERROR_DATABASE_SQL_FAILED, get_class( $this ), 'insert', $this->dbcon->ErrorMsg(), $sql ));
        return false;
         
    }


    function _makeSort() {
        if (empty($this->sort)) return false;
        return " ORDER BY ". join(", ", $this->sort);
    }

    function _makeLimit() {
        if (!( isset($this->limit) && $this->limit )) return false;
        return " LIMIT " .$this->_buildLimit();
    }

    function _buildLimit() {
        if (!isset($this->offset)) return $this->limit;
        return $this->offset . ', ' . $this->limit;
    }

    function setLimit( $qty ) {
        $this->limit = $qty;
    }

    function setOffset( $offset ) {
        $this->offset = $offset;
    }

    function getGroupedIndex($column) {
        $sql = "SELECT $column, count(" . $this->id_field . ") as qty FROM "
            . $this->datatable . $this->_makeCriteria() . " GROUP BY $column";
        AMP::debug_sql( $sql, get_class($this) . ' index');
        $result = $this->dbcon->CacheGetAssoc($sql);
        if ( !$result && $db_error = $this->dbcon->ErrorMsg( )) {
            trigger_error( sprintf( AMP_TEXT_ERROR_LOOKUP_SQL_FAILED, get_class($this) . __FUNCTION__, $db_error ) . $sql );
        }
        return $result;
    }

    function RecordCount() {
        if (!is_object($this->source)) return false;
        return $this->source->RecordCount();
    }

    function NoLimitRecordCount() {
        $sql = "SELECT count(" . $this->id_field . ") as qty from "
            . $this->datatable . $this->_makeCriteria();
        $set = $this->dbcon->Execute( $sql );


        if ( !$set && $db_error = $this->dbcon->ErrorMsg( )) {
            trigger_error( sprintf( AMP_TEXT_ERROR_LOOKUP_SQL_FAILED, get_class($this) . __FUNCTION__, $db_error ) . $sql );
			return 0;
        }
        AMP::debug_sql( $sql, get_class($this) . ' count');

        return $set->Fields( 'qty' );
    }

    function getIdFieldLookups( ) {
        if ( isset( $this->_id_field_lookups )) return $this->_id_field_lookups;
        return $this->id_field;
    }

    function setIdFieldLookups( $field ) {
        $this->_id_field_lookups = $field; 
    }

	function getLookup($field, $use_sort = false ) {
        $set = array();
		if( !$this->makeReady() ) {
			$sql = "SELECT " . $this->getIdFieldLookups( ). ", $field " . $this->_makeSource()
            . $this->_makeCriteria();
            if ( $use_sort ) {
                $sql .= $this->_makeSort( );
            }
			$set = $this->dbcon->CacheGetAssoc( $sql );
            AMP::debug_sql( $sql, get_class($this) . ' lookup');
            if ( !$set && $db_error = $this->dbcon->ErrorMsg( )) {
                trigger_error( sprintf( AMP_TEXT_ERROR_LOOKUP_SQL_FAILED, get_class($this) . __FUNCTION__, $db_error ) . $sql );
            }
		} else {
			while($record = $this->getData()) {
				$set[$record['id']] = $record[$field];
			}
		}

		return $set;
	}

    function filter( $fieldname, $value, $max_qty=null ) {
        if (!$this->makeReady()) return false;
        $result = array();
        while( $data = $this->getData() ) {
            if (isset($max_qty) && count($result)==$max_qty) break;
            if ($data[ $fieldname ] != $value) continue;
            $result[ $data[$this->id_field] ] = $data;
        }

        if (empty($result)) return false;
        return $result;
    }

    function getArray() {
        if (!$this->makeReady()) return false;
        return $this->source->GetArray();
    }

    function instantiateItems($rows, $class) {
            if(empty($rows) or !$rows or !$class or !(class_exists($class))) return false;

            $items = array();
            foreach ($rows as $row) {
                    $object = new $class();
                    $object->set_data_from_db($row);
                    $items[$object->id] = $object;
            }

            return $items;
    }


    function applySearch( $search_values, $run_query=true ) {
        $search = &$this->getSearch( );
        $search->applyValues( $search_values );
        if ( $run_query ) $this->readData( );
    }

    function &getSearch() {
        if ( !isset( $this->_search )) {
            $this->_search = new $this->_search_class( $this );
        }
        return $this->_search;
    }

    /**
     * Returns an array of fields which should be searched via exact, rather than %contains% methods 
     * 
     * @access public
     * @return array 
     */
    function &getLiteralCriteria( ){
        return $this->_search_exact_values;
    }

    /**
     * Search all defined text fields for relevance to a search string 
     * 
     * @param mixed $search_string 
     * @access public
     * @return void
     */
    function addCriteriaFulltext( $search_string, $sortby_relevance = false ) {
        $search = &$this->getSearch( );
        $fulltext_criteria = $search->getCriteriaFulltext( $search_string );
        $this->addCriteria( $fulltext_criteria );
        if ( $sortby_relevance ) $this->addSort( $fulltext_criteria . ' DESC' );
    }

    function getFullTextFields( ){
        return $this->_search_fulltext;
    }

    function makeCriteriaTag( $tag_value ) {
        if ( !isset( $this->_item_type )) {
            trigger_error( sprintf( AMP_TEXT_ERROR_NOT_DEFINED, get_class( $this ), '_item_type' ));
            trigger_error( sprintf( AMP_TEXT_ERROR_CREATE_FAILED, get_class( $this ), 'tag criteria ' . $tag_value ));
            return false;
        }
        $lookup_type =  AMP_pluralize(  $this->_item_type ) . 'ByTag' ;
        $id_set = AMPSystem_Lookup::instance( $lookup_type, $tag_value );
        if ( !$id_set || empty( $id_set )) return 'FALSE';

        return $this->id_field . ' IN ( '. join( ',', array_keys( $id_set ) ) . ')';
        
    }

    function setSortAndLimit( $options ) {
        $order_by = isset( $options['sort']) && $options['sort'] ? $options['sort'] : false;
        $source_limit = isset( $options['limit']) && $options['limit'] ? $options['limit'] : false;
        $source_offset = isset( $options['offset']) && $options['offset'] ? $options['offset'] : false;

        if ( $order_by || $source_limit || $source_offset ) {
            if( $order_by ) {
                $this->setSort( $order_by );
            }
            if ( $source_limit ) {
                $this->setLimit( $source_limit );
            }
            if ( $source_offset ) {
                $this->setOffset( $source_offset );
            }
        }
    }
    
}
