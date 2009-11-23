<?php
function basicList( $list_items, $o){
	$r =& getRenderer();

	if( isset($o['display']) && ($o['display'] == 'inline')) $o['class'] = 'inline';

	$attr = $r->attr($o);
	$html = '';
	if( isset($o['title'])) $html .= '<h3 class="basic-table-header">'.$o['title'].'</h3>';

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

	$html .= '<div class="clear-left"></div></div>';
	return "<div $attr >$html</div>";
}