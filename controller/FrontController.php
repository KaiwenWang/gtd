<?php
class FrontController {
    var $_class_name = 'FrontController';
    var $user;
    var $requestedPageController;
    var $requestedAction;
    var $requestedParams;
    var $isAuthenticated = true;
    
    function FrontController() {
        $this->__construct();
    }
    function __construct(){
        $this->getUser();
        $this->getRequest();
    }
    function execute(){
        $this->authenticate();
        if ($this->isAuthenticated){
            $page = $this->requestedPageController;
            $action = $this->requestedAction;
            return $page->$action( $this->requestedParams);
        } else {
            return 'Gew fuk yerself yah bastard!';
        }
    }
    function getUser(){
        // AH doont do nuthin' fer yeu!    
    }
    function getRequest(){
        require_once('controller/'.$_GET['controller'].'.php');
        $this->requestedPageController = new $_GET['controller'];
        $this->requestedAction = $_GET['action'];
        $this->requestedParams = $_GET;
        unset($this->requestedParams['controller']);
        unset($this->requestedParams['action']);
    }   
    function authenticate(){
        //  Me aither yeh fuukken bastard yeu!
    }
}
?>