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
function basicListItem( $data, $o){
	$r = getRenderer();
	$attributes = $r->attr( $o);
	$html = '';
	foreach ( $data as $label => $field){
		$html .= "
			<span>
				<label>
					$label
				</label>
				<span>
					$field
				</span>
			</span>
		";
	}
	return "<div $attributes >$html</div>";
}
?>