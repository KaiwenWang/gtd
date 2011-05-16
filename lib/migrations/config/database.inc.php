<?php

include( dirname(__FILE__) . '/../../../boot/database_config.php' );

//----------------------------
// DATABASE CONFIGURATION
//----------------------------
$ruckusing_db_config = array(
  
  'development' => array(
     'type'      => 'mysql',
     'host'      => 'localhost',
     'port'      => 3306,
     'database'  => DB_NAME,
     'user'      => DB_USER,
     'password'  => DB_PASS
  ),  

  'test'          => array(
      'type'      => 'mysql',
      'host'      => 'localhost',
      'port'      => 3306,
      'database'  => 'php_migrator_test',
      'user'      => 'root',
      'password'  => ''
  ),  
  'development' => array(
     'type'      => 'mysql',
     'host'      => 'localhost',
     'port'      => 3306,
     'database'  => DB_NAME,
     'user'      => DB_USER,
     'password'  => DB_PASS
  )
  
);


?>
