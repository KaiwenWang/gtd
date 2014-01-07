<?php
class Charge extends  ActiveRecord {

  var $datatable = "charge";
  var $name_field = "name";
  
  protected static $schema;
  protected static $schema_json = '{  
    "fields": {
        "company_id": "Company",
        "name": "text",
        "amount": "float",
        "type": "text",
        "description": "textarea",
        "date": "date",
        "invoice_id": "Invoice"
    },
    "required": [],
    "values": {
        "type": {
            "bandwidth": "Bandwidth Overage",
            "domain": "Domain Registration",
            "slicehost": "Slicehost",
            "amazon": "Amazon S3",
            "other": "Other"
        }
    }
  }';

  function getCompany(  ) {
    $company = new Company( $this->get( 'company_id' ));
    return $company;
  }
  function getType() {
    return $this->get('type');
  }
  function getDescription() {
    return $this->get('description');
  }
  function getDate() {
    return $this->get( 'date' );
  }
  function getAmount(){
    return $this->get('amount');
  }
  function _sort_default( &$item_set ){
    return $this->sort( $item_set, 'date', 'desc');
  }
  function getHistoryName() {
    return $this->getType();  
  }
  function getHistoryDate() {
    return $this->getDate();  
  } 
  function getHistoryDescription() {
    $desc = $this->getName();
    if( $this->getDescription()){
      $desc .= ': '.$this->getDescription();
    }
    return $desc;
  }
  function getHistoryAmount() {
    return $this->getAmount();
  }
}
