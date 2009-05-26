<?php
/**
@package view
*/
/**
	hour list item
	
	renders list display for a singe Hour objects
	
*/
function hourListItem( $hour, $o){
	$r = getRenderer();
	$data = array( 
		'Hours'=> $hour->getHours(),
		'Discount' => $hour->getDiscount(),
		'Name' => $hour->getName(),
		'Staff' => $hour->getStaffName()
	);
	$options = array( 'class' => 'hour-list-item');
	return $r->view('basicListItem', $data, $options);
}
?>