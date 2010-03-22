<?php
class UI {

	static function button($o){
		$b = new Button($o);
		return $b->execute();
	}	
}
