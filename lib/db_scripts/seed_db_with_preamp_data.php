<?php
require_once 'boot/bootstrap.php';

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


// CREATE DEFAULT STAFF INFO

$sql = "INSERT INTO `staff` (`id`, `first_name`, `last_name`, `email`,`team`) VALUES
('', 'Margot', '', 'margot@radicaldesigns.org', 'production'),
('', 'Ted', '', 'ted@radicaldesigns.org', 'production'),
('', 'Suzi', '', 'suzi@radicaldesigns.org', 'production'),
('', 'Austin', '', 'austin@radicaldesigns.org', 'development'),
('', 'Cooper', '', 'cooper@radicaldesigns.org', 'production'),
('', 'Catherine', '', 'catherine@radicaldesigns.org', 'administration')";
$ok = $DB->Execute($sql);
if( $ok ) echo "CREATED STAFF RECORDS\n";
else echo "FAILED TO CREATE STAFF RECORDS\n";


// CREATE COMPANIES FROM PREAMP EXPORT

$rows = $DB->Execute('select * from userdata where modin=66');

while(!$rows->EOF){
	
	$company_data = array(
		'name'=>$rows->Fields('Company'),
		'notes'=>$rows->Fields('custom9'),
		'street'=>$rows->Fields('Street'),
		'street_2'=>$rows->Fields('Street_2'),
		'city'=>$rows->Fields('City'),
		'state'=>$rows->Fields('State'),
		'zip'=>$rows->Fields('Zip'),
		'preamp_id'=>$rows->Fields('custom1'),
		'status'=>$rows->Fields('custom16'),
		'bay_area'=>$rows->Fields('custom11'),
		'date_started'=>$rows->Fields('custom8')
		);

	$c = new Company(); 
	$c->set($company_data);
	$c->save();	

	$billing_name = explode( ' ', $rows->Fields('custom18'), 2);
	$billing_first = !empty($billing_name[0]) ? $billing_name[0] : '';
	$billing_last = !empty($billing_name[1]) ? $billing_name[1] : '';

	$billing_data = array(
		'first_name'=>$billing_first,
		'last_name'=>$billing_last,
		'company_id'=>$c->id,
		'email'=>$rows->Fields('custom2'),
		'phone'=>$rows->Fields('Cell_Phone'),
		'is_billing_contact'=>true,
		'preamp_id'=>$rows->Fields('custom1')
	);

	$billing_contact = new Contact();
	$billing_contact->set($billing_data);
	$billing_contact->save();

	$primary_name = explode( ' ', $rows->Fields('custom17'), 2);
	$primary_first = !empty($primary_name[0]) ? $primary_name[0] : '';
	$primary_last = !empty($primary_name[1]) ? $primary_name[1] : '';

	$primary_data = array(
		'first_name'=>$primary_first,
		'last_name'=>$primary_last,
		'company_id'=>$c->id,
		'email'=>$rows->Fields('custom3'),
		'phone'=>$rows->Fields('Phone'),
		'is_primary_contact'=>true,
		'preamp_id'=>$rows->Fields('custom1')
	);

	$primary_contact = new Contact();
	$primary_contact->set($primary_data);
	$primary_contact->save();

	$balance_data = array(
		'company_id' => $c->id,
		'date' => '2010-03-01',
		'amount' => $rows->Fields('custom12')		
	);

	$balance = new CompanyPreviousBalance();
	$balance->set($balance_data);
	$balance->save();

	$c->getData('status') == 'closed' ?  $contract_status = 'cancelled'
									  :  $contract_status = 'active'; 
	$contract_data = array(
		'domain_name'=>'Old Preamp Contract',
		'company_id'=>$c->id,
		'status'=>$contract_status,
		'monthly_rate'=>$rows->Fields('custom5'),	
		'support_hours'=>$rows->Fields('custom7'),	
		'hourly_rate'=>$rows->Fields('custom6'),	
		'start_date'=>$rows->Fields('2009-12-25')
	);

	$contract = new SupportContract();
	$contract->set($contract_data);
	$contract->save();

	$rows->MoveNext();
}
