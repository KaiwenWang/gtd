<?php

require_once('constants.php');
require_once('boot/database_config.php');
require_once('lib_includes.php');
require_once( 'utility/main_utilities.php');
Util::include_directory('model');
Util::include_directory('render');
Util::include_directory('router');
require_once('controller/PageController.php');
