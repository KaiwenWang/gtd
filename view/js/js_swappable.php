<?php
function jsSwappable( $title, $o){
	return 	'
		<div class="js-swappable">
			<a class="js-swappable-btn" href="#">Edit</a>
			<div class="title">'.$title.'</div>
			<div class="clear"></div>
			<div class="swappable-item">'.$o[0].'</div>
			<div class="swappable-item" style="display:none;">'.$o[1].'</div>
		</div>
			';
}
?>