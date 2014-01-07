<?php
class ClientUser extends User{

  var $datatable = "client_user";
  var $name_field = "first_name";

  protected static $schema;
  protected static $schema_json = '{  
    "fields": {
        "first_name": "text",
        "last_name": "text",
        "company_id": "Company",
        "email": "text",
        "username": "text",
        "password": "text"
    },
    "required": [],
    "values": {}
  }';

  function __construct( $id = null){
    parent::__construct( $id);
  }

  function getUserType(){
    return 'client';
  }

  function getCompany(){
    return new Company($this->get('company_id'));
  }

  function getCompanyName(){
    return $this->getCompany()->getName();
  }
}
