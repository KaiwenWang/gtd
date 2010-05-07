<?php
class Session {

	static $user_id;
	static $user_type;
	
	static function startSession( $user_id, $user_type){
		$_SESSION['gtd_user'] = $user_id;
		$_SESSION['gtd_user_type'] = $user_type;
		self::$user_id = $user_id;
		self::$user_type = $user_type;
	}
	static function endSession( ){
		session_destroy();
	}
	static function getUser(){
		if( !self::sessionExists() ) return false;
		return self::$user_id	? self::$user_id
								: $_SESSION['gtd_user'];
	}
	static function getUserType(){
		return self::$user_type	? self::$user_type
								: $_SESSION['gtd_user_type'];
	}
	static function sessionExists( ) {
		if ( isset($_SESSION['gtd_user']) || self::$user_type) return true;
	}
}
?>
