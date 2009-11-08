<?php
function jsHideable( $items){

	$hideable_items = '';

	foreach( $items as $header=>$item){
		
		$hideable_items .= '
			<div class="hideable-block">	
				<a class="js-hideable-btn" href="#">
					<b>+</b> <span class="title">'.$header.'</span>
				</a>
				<div class="hideable-item" style="display: none;">
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