<?php
function jsHideable( $items, $options){
	isset($options['open_by_default']) 	? $open_by_default = array_flip( $options['open_by_default'])
										: $open_by_default = array();
	$hideable_items = '';

	foreach( $items as $header=>$item){
		array_key_exists( $header, $open_by_default) ? $style = ''
													 : $style = 'display: none;';
		$hideable_items .= '
			<div class="hideable-block">	
				<a class="js-hideable-btn" href="#">
					<b>+</b> <span class="title">'.$header.'</span>
				</a>
				<div class="hideable-item" style="'.$style.'">
					'.$item.'
				</div>
			</div>
			';
	}							
	
	return 	'
		<div class="js-hideable">
			'.$hideable_items.'
		</div>
			';
}
?>
