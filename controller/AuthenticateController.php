<?php
class AuthenticateController extends PageController {
	
	protected $authentication_type = 'public';
	
	function login($params){

	}
	function widget(){
		if (getUser()){
			$this->data->user = new Staff(getUser());
			$this->data->is_logged_in = true;
		}
	}
	function create_session($params){
		$username = $params['username'];
		$password = sha1($params['password']);
		$auth_type = $params['auth_type'];
		$user_class = class_case($auth_type);

		$user = $user_class::getOne(array('username'=>$username,'password'=>$password));
		if( $user ){
			Session::startSession( $user->id, $user->getUserType());
			$this->redirectTo( array('controller'=>$user_class,'action'=>'show','id'=>$user->id));
		} else {
			$this->redirectTo( array('controller'=>'Authenticate','action'=>'login','auth_type'=> $auth_type, 'username'=>$username));
		}	
	}
	
	function destroy_session($params){
		Session::endSession();
		$this->redirectTo( array('controller'=>'Authenticate','action'=>'login'));
	}
	
}
?>
