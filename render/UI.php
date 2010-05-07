<?php
class UI {

	static function button($params){
		$b = new Button($params);
		return $b->execute();
	}
	// array $params takes the following items:
	// text: link text to display
	// controller: controller name (same case as the controller class)
	// action: controller action
	//
	// any other params passed in go into the uri string and are passed to the action as params 
	//
	// alternatively, pass the param 'url' to hard-code a url.
	static function link($params,$o = array()){
		$l = new Link($params,$o);
		return $l->execute();
	}
}
