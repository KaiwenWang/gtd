<?php

//include the AMP constants for db connection
include $_SERVER['HOME']."/public_html/custom/config.php";
//----------------------------
// DATABASE CONFIGURATION
//----------------------------
$ruckusing_db_config = array(
	
  'development' => array(
     'type'      => $MM_DBTYPE,
     'host'      => $MM_HOSTNAME,
     'port'      => 3306,
     'database'  => $MM_DATABASE,
     'user'      => $MM_USERNAME,
     'password'  => $MM_PASSWORD
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
