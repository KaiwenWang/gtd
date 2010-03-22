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
        if ( isset($_POST['controller']) && $_POST['controller']){
            $this->controller = $_POST['controller'].'Controller';
            $this->controller_prefix = $_POST['controller'];
            isset( $_POST['action'] ) 	? $this->action = $_POST['action'] 
            							: $this->action = 'post';
            $this->method = 'post';
        } elseif (  isset(  $_GET['controller']) && $_GET['controller']) {
            $this->controller = $_GET['controller'].'Controller';
            $this->controller_prefix = $_GET['controller'];
            isset( $_GET['action']) ? $this->action = $_GET['action'] 
            						: $this->action = 'index';
            $this->method = 'get';
        } else {
            $this->controller = 'HomePageController';
            $this->action = 'index';
            $this->method = 'get';
            $this->controller_prefix = 'HomePage';
        }
		$this->initializeParams();
    }
    
    function params( ) {
        if( $this->params) return $this->params;
		$this->initializeParams();
        return $this->params;
    }
    
	function initializeParams(){
		$this->method == 'get' ? $params = $_GET
							   : $params = $_POST;
        unset( $params['controller']);
        unset( $params['action']);
        $this->params = $params;
	}
	
    function controller_path( ) {
        $path = 'controller/'.$this->controller.'.php';
		if (!file_exists( $path)) bail( 'requested controller "'.$this->controller.'" does not exist.');
        return $path;
    }

    static function url($parameters){
/*
	    if( is_a( $parameters, 'ActiveRecord')){
			$obj = $parameters;
			$parameters = array( 'action'=>'show','id' => $obj->id );
	    }
*/
    	return 'index.php?'.http_build_query($parameters);
    }
}
?>
