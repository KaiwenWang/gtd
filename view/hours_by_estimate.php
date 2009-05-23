<?php
function hoursByEstimate( $estimates, $o = array()){
    $r = getRenderer();
	$id = 'id="'.$o['id'].'" ';
	$html = '';
	foreach($estimates as $e){
		$html .= '<li>'.$e->getName().'- Estimate Hours: '.$e->getLowEstimate().'-'.$e->getHighEstimate().' Billable hours: '.$e->getBillableHours().'</li>';
		$hours = $e->getHours();
     	$html .= $r->view('hoursForEstimate', $hours, array('id'=>'test'));
	}
	return "<ul $id>$html</ul>";

}
?>
