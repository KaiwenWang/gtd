<?php
class AuthenticateController extends PageController {
	
	protected $authentication_type = 'public';
	
	function login(){
	}
	function widget(){
		if (getUser()){
			$this->data->user = new Staff(getUser());
			$this->data->is_logged_in = true;
		}
	}
	function create_session($params){
		Session::startSession( $params['id'], 'staff');
		$this->redirectTo( array('controller'=>'Staff','action'=>'show','id'=>$params['id']));
	}
	
	function destroy_session($params){
		Session::endSession();
		$this->redirectTo( array('controller'=>'Authenticate','action'=>'login'));
	}
	
}
?>
