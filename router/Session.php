<?php
class Session {
	static function startSession( $user_id, $user_type){
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_type'] = $user_type;
	}
	static function endSession( ){
		session_destroy();
	}
	static function getUserId(){
		return $_SESSION['user_id'];
	}
	static function getUser(){
		if( !self::sessionExists() ) return false;

		$user_type = self::getUserType();
		switch($user_type) {
			case 'staff':
				$class_name = 'Staff';
				break;
			case 'client':
				$class_name = 'ClientUser';
				break;
		}
		$user = new $class_name(self::getUserId());
		return $user;
	}
	static function getUserType(){
		return $_SESSION['user_type'];
	}
	static function sessionExists() {
		if(!empty($_SESSION['user_id'])) {
			return true;
		} else {
			return false;
		}
	}
}
?>
