<?php
class Router{
    var $controller;
    var $controller_prefix;
    var $action;
    var $method;
    var $params;
 	private static $instance;

  	public static function singleton() {
    	if(!isset(self::$instance)) {
	      $c = __CLASS__;
    	  self::$instance = new $c();
	    }
    	return self::$instance;
 	 }

	private function __construct( ){
        if ( $_POST['controller'] && isset($_POST['controller'])){
            $this->controller = $_POST['controller'].'Controller';
            $this->controller_prefix = $_POST['controller'];
            isset( $_POST['action'] ) 	? $this->action = $_POST['action'] 
            							: $this->action = 'post';
            $this->method = 'post';
        } elseif ( $_GET['controller'] && isset(  $_GET['controller'])) {
            $this->controller = $_GET['controller'].'Controller';
            $this->controller_prefix = $_GET['controller'];
            isset( $_GET['action']) ? $this->action = $_GET['action'] 
            						: $this->action = 'get';
            $this->method = 'get';
        } else {
            $this->controller = 'HomePageController';
            $this->action = 'index';
            $this->method = 'get';
            $this->controller_prefix = 'HomePage';
        }
    }

    function params( ) {
        if( $this->params) return $this->params;
        $params = $_GET + $_POST;
        unset( $params['controller']);
        unset( $params['action']);
        $this->params = $params;
        return $this->params;
    }

    function controller_path( ) {
        $path = 'controller/'.$this->controller.'.php';
		if (!file_exists( $path)) bail( 'requested controller "'.$this->controller.'" does not exist.');
        return $path;
    }
}
?>
