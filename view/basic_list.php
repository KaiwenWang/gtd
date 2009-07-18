<?php
/**
@package view
*/
/**
	basic list item
	
	basic pattern for a single row in a table/list display
	
	data (array):
	['headers'] array of column headers
	['rows'] array of rows, each row is an array of data
	
*/
function basicList( $list_items){
	$html = '<table class="basic-list" cellpadding="0" cellspacing="0">';
	foreach( $list_items as $label=>$item) $html .= "<tr><td><label class=\"basic-list-label\">$label</label></td><td><span class=\"basic-list-item\">$item</span></td></tr>";
	$html .= '</table>';
	return $html;
}
?>