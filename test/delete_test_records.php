<?php
$companies = destroyRecords( 'Company', array('name'=>'destroy_test'));
$companies = destroyRecords( 'Company', array('name'=>'Billing Test'));

function destroyRecords( $model, $criteria ){
	$records = getMany( $model, $criteria );
	$i = 0;
	if($records){
		foreach ($records as $record) {
			$record->destroyAssociatedRecords();
			$record->delete();
			$i++;
		}
		echo "Deleted $i test $model: ".array_dump($criteria)."<br>";	
	}else{
		echo "No test $model found: ".array_dump($criteria)."<br>";
	}
}
