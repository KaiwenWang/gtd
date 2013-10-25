<?php
/**
\brief  Basic Model Class for GTD

Extend ActiveRecord in the /model directory to create a new GTD model.
 */
class ActiveRecord  extends Record {
  var $name_field;

  protected static $schema;
  protected static $schema_json;  

  function get($field = null){
    $s = $this::_getSchema(get_class($this));
    if ( !empty($s['values']) && !empty($s['values'][$field])) return $s['values'][$field][parent::get($field)];
    return parent::get($field);
  }
  // get raw value from db
  function getData($field = null){
    return $this->escape(parent::get($field));
  }
  function set($field){
    return parent::set($field);
  }
  function getName(){
    return $this->getData($this->name_field);
  }
  function destroy(){
    return $this->delete();
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
  function getFieldType( $field){
    $s = $this::_getSchema(get_class($this));
    if ( !array_key_exists( $field, $s['fields'])) bail("db field '$field' does not exist in schema file for ".get_class($this).".");
    if ( !$s['fields'][$field]) bail( "db field '$field' exists in schema file, but does not have it's type set");
    if ( !empty($s['values']) && !empty($s['values'][$field])) return $s['values'][$field];
    return $s['fields'][$field];
  } 
  private static function _getSchema($class=''){
    if ( !isset( $class::$schema)) {
      $r =& getRenderer();
      $class::$schema = $r->jsonDecode( $class::$schema_json);
    }
    return $class::$schema;
  }
  function getHistory($o = array()){
    if(!empty($o['types'])){
      $types = array_intersect($o['types'],$this->history_types);
      unset($o['types']);
    } else {
      $types = $this->history_types;
    }

    $history = array();
    foreach( $types as $type){
      $method_name = 'get'.$type;
      if( !method_exists($this,$method_name)) bail('method '.get_class($this)."::$method_name not found");
      $history_objects = $this->$method_name();
      if(!$history_objects) continue;
      $history = array_merge( $history, $history_objects);
    }

    usort( $history, array($this,'compareHistoryDates'));      

    return $history;
  }
  function compareHistoryDates( $a, $b){
    $date_a = $a->getHistoryDate();
    $date_b = $b->getHistoryDate();

    if($date_a == $date_b) return 0;
    return ($date_a > $date_b) ? -1 : 1;
  }
  function getHistoryType(){
    return get_class($this);
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

  function makeCriteriaCurrentMonth($date_field){
    if( !$date_field || $date_field === true) $date_field = 'date';

    $start_date = Util::date_format_from_time(Util::start_of_current_month());
    $end_date = Util::date_format_from_time(Util::end_of_current_month());

    $criteria = array(
      'field_name'=>$date_field,
      'start_date'=>$start_date,
      'end_date'=>$end_date
    );

    return $this->makeCriteriaDateRange( $criteria );
  }

  function makeCriteriaCurrentWeek($date_field){
    if( !$date_field || $date_field === true) $date_field = 'date';

    $start_date = Util::date_format_from_time(Util::start_of_current_week());
    $end_date = Util::date_format_from_time(Util::end_of_current_week());

    $criteria = array(
      'field_name'=>$date_field,
      'start_date'=>$start_date,
      'end_date'=>$end_date
    );

    return $this->makeCriteriaDateRange( $criteria );
  }


  protected function _makeCriteriaMultiple($fieldname, $values) {
    if(empty($values)) return;
    if(is_array($values)) {
      return "$fieldname IN (". implode(",", $values). ")";
    }
    return "$fieldname = " . $this->dbcon->qstr( $values );
  }

  function isValid() {
    //stub
    return true;
  }

  function destroyAssociatedRecords(){
    // overwrite in subclass
  }

  function escape($string) {
    $from_array = array(
      0 => '$'
    );

    $to_array = array(
      0 => '&#36;'
    );
    return str_replace($from_array, $to_array, $string);
  }

}
