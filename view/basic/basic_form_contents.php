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
function basicFormContents( $list_items, $o){
	$r =& getRenderer();
	$html = '';

	isset($o['class']) 	? $o['class'] .= ' basic-form-contents'
						: $o['class'] = 'basic-form-contents';
	isset($o['title'])	? $html .= '<h3 class="basic-form-header">'.$o['title'].'</h3>'
						: $html .= '<h3 class="basic-form-header"></h3>';

	$html .= '<div class="basic-list" cellpadding="0" cellspacing="0">';

	foreach( $list_items as $label=>$item) $html .= "
			<div class='basic-list-item'>
				<div class='label-cell basic-cell'>
					<label class='basic-list-label'>$label</label>
				</div>
				<div class='data-cell basic-cell'>
					<span class='basic-list-item'>$item</span>
				</div>
			</div>";

	$html .= '</div>';
	$attr = $r->attr($o);
	
	return "<div $attr >$html</div>";
}
?>