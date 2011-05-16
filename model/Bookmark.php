<?php
class Bookmark extends ActiveRecord {

	var $datatable = "bookmark";
	var $name_field = "id";
    
  protected static $schema;
  protected static $schema_json = "{	
    'fields'   : {	
      'staff_id':  'Staff',
      'source'  	:  'text',
      'alias'  	:  'text',
      'description'  	:  'text',
    },
    'required' : { 
      'staff_id,
      'source'
          }
    }";

  
  function __construct( $id = null){
      parent::__construct( $id);
  }
	function getName(){
		return $this->getData('id');
	}
  function getStaff(){
		if(empty($this->staff)){
			$this->staff = new Staff( $this->get('staff_id'));
		}
		return $this->staff;	
	}
	function getDescription(){
		return $this->get('description');
	}
  	
	function getSource(){
		return $this->get('source');
	}

	function getAlias(){
		return $this->get('description');
	}
  
  function namespaceAlias($alias){
    if(!$alias){
      bail('you must specify an alias');
    }
    return '/' . $this->getStaff()->getPermalink() . '/' . $alias;
  }
}
