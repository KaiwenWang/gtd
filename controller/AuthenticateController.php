<?php
class AuthenticateController extends PageController {

	function login(){
	}
	function widget(){
		if (getUser()){
			$this->data->user = new Staff(getUser());
			$this->data->is_logged_in = true;
		}
	}
	function create_session($params){
		Session::startSession($params['id']);
		$this->redirectTo( array('controller'=>'Staff','action'=>'show','id'=>$params['id']));
	}
	
	function destroy_session($params){
		Session::endSession();
		$this->redirectTo( array('controller'=>'Authenticate','action'=>'login'));
	}
	
}
?>