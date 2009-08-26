<?php
class Router{
    var $controller;
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

	function __construct( ){
        if ( isset( $_POST['controller'])){
            $this->controller = $_POST['controller'].'Controller';
            $this->controller_prefix = $_POST['controller'];
            $this->action = isset( $_POST['action'] ) ? $_POST['action'] : 'post';
            $this->method = 'post';
        } elseif ( isset(  $_GET['controller'])) {
            $this->controller = $_GET['controller'].'Controller';
            $this->controller_prefix = $_GET['controller'];
            $this->action = isset( $_GET['action']) ? $_GET['action'] : 'get';
            $this->method = 'get';
        } else {
            $this->controller = 'HomePageController';
            $this->method = 'get';
            $this->controller_prefix = $_GET['controller'];
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
