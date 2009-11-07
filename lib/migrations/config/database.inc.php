<?php

//include the AMP constants for db connection
include $_SERVER['HOME']."/gtd/include/database_config.php";
//----------------------------
// DATABASE CONFIGURATION
//----------------------------
$ruckusing_db_config = array(
	
  'development' => array(
     'type'      => 'mysql',
     'host'      => DB_HOST,
     'port'      => 3306,
     'database'  => DB_NAME,
     'user'      => DB_USER,
     'password'  => DB_PASS
  ),

	'test' 					=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 3306,
			'database' 	=> 'php_migrator_test',
			'user' 			=> 'root',
			'password' 	=> ''
	),
	'production' 		=> array(
			'type' 			=> 'mysql',
			'host' 			=> 'localhost',
			'port'			=> 0,
			'database' 	=> 'prod_php_migrator',
			'user' 			=> 'root',
			'password' 	=> ''
	)
	
);


?>
