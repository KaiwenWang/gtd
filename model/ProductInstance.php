<?php

class ProductInstance extends ActiveRecord {

  var $datatable = 'product_instance';
  var $name_field = 'domain_name';        
  protected static $schema;
  protected static $schema_json = '{  
    "fields"   : {  
      "domain_name"    :  "text", 
      "technology"    :  "text", 
      "dns_notes"    :  "textarea", 
      "other_domain_names"  :  "textarea", 
      "server"      :  "text", 
      "subsites"    :  "textarea", 
      "server_account":  "textarea", 
      "apache_file"    :  "text", 
      "contract_id"    :  "Contract", 
      "wordpress"    :  "bool", 
      "oscom"      :  "bool", 
      "drupal"      :  "bool", 
      "secure_domain" :  "bool", 
      "china_ip"    :  "bool", 
      "phplist"      :  "bool",    
      "company_id"    :  "Company", 
      "notes"      :  "textarea"
    }, 
    "required" : []
  }';  

  function __construct($id = null) {
    parent::__construct($id);
  }

}

?>
