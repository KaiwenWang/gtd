<?php

class AuthenticateController extends PageController {
  
  protected $authentication_type = 'public';
  public $template = 'gtd_login';
  
  function login($params) {
    $this->data->email = (isset($params['email']) ? $params['email'] : '');
  }

  function widget() {
    $user = Session::getUser();
    if($user) {
      $this->data->user = $user;
      $this->data->is_logged_in = true;
    }
  }

  function create_session($params) {
    $email= $params['email'];
    $password = sha1($params['password']);

    // search for users in this order
    $user_classes = array('ClientUser', 'Staff');

    foreach($user_classes as $user_class) {
      $user = $user_class::getOne(array('email'=>$email,'password'=>$password));
      if($user) {
        Session::startSession( $user->id, $user->getUserType());
        if($user_class == 'Staff') {
          $this->redirectTo( array('controller'=>'Staff','action'=>'show','id'=>$user->id));
        } else if($user_class == 'ClientUser') {
          $this->redirectTo( array('controller'=>'Client','action'=>'index'));
        }
        return;
      }
    }

    // no user found    
    Render::msg('Invalid Email or Password','bad');
    $this->redirectTo( array('controller'=>'Authenticate','action'=>'login','email'=>$email));
  }
  
  function destroy_session($params) {
    Session::endSession();
    $this->redirectTo( array('controller'=>'Authenticate','action'=>'login'));
  }
  
}

?>
