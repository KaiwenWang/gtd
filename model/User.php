<?php
abstract class User extends ActiveRecord{

    function __construct( $id = null){
        parent::__construct( $id);
    }

    function getName() {
        return $this->get('first_name').' '.$this->get('last_name');
    }
    function getFirstName(){
        return $this->get('first_name');
    }
    function getLastName(){
        return $this->get('last_name');
    }
    function getEmail(){
        return $this->get('email');
    }
    function getUsername() {
        return $this->get('email');
    }

    function getPassword(){
        return $this->get('password');
    }

    function setUsername( $username ){
        $this->set(array('email'=>$username));
    }

    function setPassword( $password ){
        $this->set(array('password'=>$password));
        $this->encryptPassword();
    }

    function encryptPassword(){
        $password = $this->get('password');
        $this->set(array('password'=>sha1($password)));
    }

    function getUserType(){
        bail('method getUserType must be defined in a subclass. (i.e. the actual user class you are trying to get an instance of)');
    }

    function emailLoginLink(){
    }
}
