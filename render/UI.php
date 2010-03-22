<?php
class UI {

	static function button($params){
		$b = new Button($params);
		return $b->execute();
	}
	static function link($params,$o){
		$l = new Link($params,$o);
		return $l->execute();
	}
}
