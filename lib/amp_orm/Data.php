<?php
class Data {

    protected $dbcon;
    protected $datatable;
    protected $source;

    protected $sql_criteria = array();
    protected $_sql_select = array();

    protected $_nativeColumns = array( );
    protected $id_field = "id";
    protected $name_field = "name";

    protected $errors = array();

    function __construct( &$dbcon ) {
        $this->dbcon = &$dbcon;
        $this->setSource( $this->datatable );

        if (method_exists( $this, '_register_criteria_dynamic' )) {
            $this->_register_criteria_dynamic();
        }
    }

    function setSource( $sourcename = null ) {
        if (!isset($sourcename)) return false;
        if (!$cols = $this->_getColumnNames( $sourcename )) return false;
        $this->datatable = $sourcename;
        $this->_nativeColumns = $cols;
    }

    function setSelect( $expression_set ) {
        if (!is_array($expression_set)) return false;
        $this->_sql_select = array();
        foreach ($expression_set as $exp) {
            $this->addSelectExpression( $exp );
        }
    }
    function setCriteria( $expression_set ) {
        if (!is_array($expression_set)) return false;
        $this->sql_criteria = array();
        foreach ($expression_set as $exp) {
            $this->addCriteria ( $exp );
        }
    }

    function getCriteria () {
        if (empty($this->sql_criteria)) return false;
        return $this->sql_criteria;
    }

    function addColumn ( $name ) {
        if (!isColumn( $name )) return false;
        return $this->addSelectExpression( $name );
    }

    function isColumn( $exp ) {
        if ( empty( $this->_nativeColumns ) && !isset( $this->datatable )) return false;
        if ( empty( $this->_nativeColumns )) {
            $this->setSource( $this->datatable );
            if ( empty( $this->_nativeColumns )) return false;
        }
        if (array_search( $exp, $this->_nativeColumns ) === FALSE) return false;
        return true;
    }

    function addSelectExpression( $exp ) {
        if (!is_string($exp)) return false;
        if (array_search( $exp, $this->_sql_select )!==FALSE) return true;
        $this->_sql_select[] = $exp;
        return true;
    }

    function addCriteria( $exp ) {
        if (!is_string($exp)) return false;
        if (array_search( $exp, $this->sql_criteria )!==FALSE) return true;
        $this->sql_criteria[] = $exp;
        return true;
    }

    function hasData() {
        if (empty($this->source)) return false;
        if (method_exists($this->source, "RecordCount")) return $this->source->RecordCount();
        return true;
    }

    function _assembleSQL( $criteria = null ) {
        $sql  = $this->_makeSelect();
        $sql .= $this->_makeSource();
        $sql .= isset( $criteria ) ? 
                    ' WHERE ' . $criteria 
                    : $this->_makeCriteria();
        return $sql;
    }

    function _makeSelect( ) {
        $output  = "Select ";
        if (empty($this->_sql_select)) return $output . "*";
        return $output . join(", ", $this->_sql_select);
    }

    function _makeSource( ) {
        if ($this->datatable) return " FROM " . $this->datatable;

        trigger_error ("No datatable set in ". get_class($this));
        return false;
    }

    function _makeCriteria() {
        if (empty($this->sql_criteria)) return false;
        return ' WHERE ' . join( " AND ", $this->sql_criteria );
    }

    function _getColumnNames( $sourceDef ) {
        return AMP::get_column_names( $sourceDef );
    }

    # sets a minimum id for the next database insert
    function _setSourceIncrement( $new_value ){
        if ( $lowest_id = lowerlimitInsertID($this->datatable, $new_value)) {
            $this->dbcon->Execute( "ALTER TABLE ".$this->datatable." AUTO_INCREMENT = ".$lowest_id);
        }

    }

    # validation error handling code
    function addError( $error ) {
        $this->errors[] = $error;
    }

    function getErrors() {
        return join("<BR>" , $this->errors);
    }

}