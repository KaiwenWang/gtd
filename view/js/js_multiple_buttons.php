<?php
function jsMultipleButtons( $items, $options){
	isset($options['open_by_default']) 	? $open_by_default = array_flip( $options['open_by_default'])
										: $open_by_default = array();

	$multiple_buttons = '';
	$target_html = '';

	foreach( $items as $header=>$item){
		array_key_exists( $header, $open_by_default) ? $style = ''
													 : $style = 'display: none;';
		$multiple_buttons.= '
				<a class="js-multiple-buttons-btn button" href="#">
					<span class="title">'.$header.'</span>
				</a>
			';
		$target_html .=' 
					<div class="multiple-buttons-item" style="'.$style.'">
						'.$item.'
					</div>
					';				
	}
	
	return 	'
		<div class="js-multiple-buttons">
			'.$multiple_buttons.'
			<div class="js-multiple-buttons-target">
				'.$target_html.'
			</div>
		</div>
			';
}
