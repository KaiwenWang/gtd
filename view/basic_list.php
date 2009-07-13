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
	$html = '<ul class="basic-list">';
	foreach( $list_items as $label=>$item) $html .= "<li><label>$label</label>$item</li>";
	$html .= '</ul>';
	return $html;
}
?>