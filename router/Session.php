<?php
class Session {

	static $user_id;
	
	static function startSession( $user_id){
		setcookie( 'gtd_user', $user_id);
		self::$user_id = $user_id;
	}
	static function endSession( ){
		setcookie( 'gtd_user', false);
	}
	static function getUser(){
		return self::$user_id	? self::$user_id
								: $_COOKIE['gtd_user'];
	}
}
?>