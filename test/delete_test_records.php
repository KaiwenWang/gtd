<?php
$companies = getMany('Company',array('name'=>'destroy_test'));
$companies = array_merge( $companies, getMany('Company',array('name'=>'Billing Test')));
$i = 0;
if($companies){
	foreach ($companies as $company) {
		$company->destroyAssociatedRecords();
		$company->delete();
		$i++;
	}
	echo "Deleted $i test companies";	
}else{
	echo "No test companies found";
}
