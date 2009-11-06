<?php 
ADOLoadCode('mysql');

$dbcon =& ADONewConnection( 'mysql' );
if (! $dbcon->Connect( DB_HOST, DB_USER, DB_PASS, DB_NAME )) {
    die( 'Connection to database '.DB_NAME.' was refused.  Please check database_config file.' );
}
