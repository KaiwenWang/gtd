<?php

require_once('constants.php');
if( !file_exists('boot/database_config.php' )){
	trigger_error('DB config not found. Please create a file bool/database_config.php and define DB_HOST, DB_NAME, DB_USER, DB_PASS', E_USER_ERROR);
}
require_once('boot/database_config.php');
require_once('lib_includes.php');
require_once( 'utility/main_utilities.php');
Util::include_directory('model');
Util::include_directory('render');
Util::include_directory('router');
require_once('controller/PageController.php');
