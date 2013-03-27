<?php
function jsSwappable( $title, $o){
	isset( $o['button_text']) ? $button_text = $o['button_text']
							  : $button_text = 'Edit';
	return 	'
		<div class="js-swappable">
	    	<div class="bs-docs-example" id="Summary">
				<a class="js-swappable-btn little-button" >'.$button_text.'</a>
				<div class="swappable-item">'.$o[0].'</div>
				<div class="swappable-item" style="display:none;">'.$o[1].'</div>
			</div>
		</div>
			';
}
?>
