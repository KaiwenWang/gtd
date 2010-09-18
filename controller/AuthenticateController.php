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
		$email= $params['email'];
		$password = sha1($params['password']);
		$auth_type = $params['auth_type'];
		$user_class = class_case($auth_type);

		$user = $user_class::getOne(array('email'=>$email,'password'=>$password));
		if( $user ){
			Session::startSession( $user->id, $user->getUserType());
			$this->redirectTo( array('controller'=>$user_class,'action'=>'show','id'=>$user->id));
		} else {
			Render::msg('Invalid Email or Password','bad');
			$this->redirectTo( array('controller'=>'Authenticate','action'=>'login','email'=>$email));
		}	
	}
	
	function destroy_session($params){
		Session::endSession();
		$this->redirectTo( array('controller'=>'Authenticate','action'=>'login'));
	}
	
}
?>
