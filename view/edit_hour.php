<?php
function editHour( $hour){
	$r =& getRenderer();
	$html = '
		<div><label>Estimate</label>'.$r->field( $hour, 'estimate_id').'</div>
		<div><label>Description</label>'.$r->field( $hour, 'description').'</div>
		<div><label>Staff</label>'.$r->field( $hour, 'staff').'</div>
		<div><label>Date</label>'.$r->field( $hour, 'date').'</div>
		<div><label>Hours</label>'.$r->field( $hour, 'hours').'</div>
		';
	return $html;
}
?>