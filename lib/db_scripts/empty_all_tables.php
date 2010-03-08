<?php
require_once 'include/bootstrap.php';

// BACKUP DB TO DISC
$path = realpath(__DIR__);
$backupFile = $path.'/gtd_db_backup_' . date("Y-m-d-H-i-s")  . '.sql';
$command = 'mysqldump --opt -h '. DB_HOST .' -u '. DB_USER .' -p '. DB_PASS .' '. DB_NAME.' > '.$backupFile;
echo $command;
system($command);

// ESTABLISH DB CONNECTION
$DB = NewADOConnection('mysql');
$DB->Connect( DB_HOST, DB_USER, DB_PASS, DB_NAME);


// EMPTY TABLES
$tables = array(
			 'company',
			 'bandwidth',
			 'contact',
			 'charge',
			 'estimate',
			 'hour',
			 'invoice',
			 'invoice_item',
			 'payment',
			 'payment',
			 'product_instance',
			 'project',
			 'staff',
			 'support_contract',
			 'company_previous_balance',
			 'status'
			);

foreach ( $tables as $table){
	$ok = $DB->Execute( 'TRUNCATE '. $table .'');
	if( $ok ) echo "TRUNCATED TABLE $table\n";
	else echo "FAILED TO TRUNCATE TABLE $table\n";
}

