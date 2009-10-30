<?php
class Session {

	static $user_id;
	static $user_type;
	
	static function startSession( $user_id, $user_type){
		setcookie( 'gtd_user', $user_id);
		setcookie( 'gtd_user_type', $user_type);
		self::$user_id = $user_id;
		self::$user_type = $user_type;
	}
	static function endSession( ){
		setcookie( 'gtd_user', false);
		setcookie( 'gtd_user_type', false);
	}
	static function getUser(){
		return self::$user_id	? self::$user_id
								: $_COOKIE['gtd_user'];
	}
	static function getUserType(){
		return self::$user_type	? self::$user_type
								: $_COOKIE['gtd_user_type'];
	}
}
?>