<?php

class AMP {
    function getDb(){
        static $dbcon;
        
        if($dbcon) return $dbcon;

        ADOLoadCode('mysql');
        $dbcon =& ADONewConnection( 'mysql' );
        if (! $dbcon->Connect( DB_HOST, DB_USER, DB_PASS, DB_NAME )) {
            die( 'Connection to database '.DB_NAME.' was refused.  Please check database_config file.' );
        }
        return $dbcon;
    }
    function getDbcon(){
      return AMP::getDb();
    }
    function array_filter_by_keys( $filter, $data){
      return array_intersect_key( $data, array_flip($filter)); 
    } 
  function camelcase( $value ) {
      return str_replace( ' ', '', ucwords( str_replace( '_', ' ', $value )));
  }

  function get_column_names( $table_name ) {
    static $table_defs;
    if (isset($table_defs[$table_name] )) return $table_defs[$table_name];
    $table_defs[$table_name] = AMP::getDbcon()->MetaColumnNames($table_name);
    return $table_defs[$table_name];
      #AMP_cache_set( AMP_REGISTRY_SYSTEM_DATASOURCE_DEFS, $definedSources );

  }

}
