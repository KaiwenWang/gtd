<?php

function bookmarkTable( $bookmarks, $o = array()){
	if( !$bookmarks) return;
	$r =& getRenderer();
	$html = '<h4>Bookmarks</h4><ul id="bookmark-list">';	
	foreach($bookmarks as $b){
		$html.="
			<li>
				<a class='button' href='" .$b->getSource()."'>".$b->getDescription()."</a>
			</li>";
	}
	$html .= '</ul>';
	return $html;
}
