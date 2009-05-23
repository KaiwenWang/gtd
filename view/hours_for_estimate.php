<?php

function hoursForEstimate( $hours, $o = array()){
	$id = 'id="'.$o['id'].'" ';
	$html = '';
	foreach($hours as $h){
		$staff = $h->getStaff();
		$html .= '<li>Hours: '.$h->getHours().'-'.$h->getName().' ('.$staff->getName().')</li>';
	}
	return "<ul $id>$html</ul>";
}

?>
