<?php
/**
@package view
*/
/**
	hour list item
	
	renders list display for a singe Hour objects
	
*/
function hoursList( $hours, $o){
	$r =& getRenderer();
	$html = '';
	if ( !$o['class']) $o['class'] = 'hours-list';
	$attributes = $r->attr( $o);
	foreach ($hours as $h){
		$html .= $r->view( 'hourListItem', $h);
	}
	return "<div $attributes >$html</div>";
}
?>