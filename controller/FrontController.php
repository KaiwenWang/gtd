<?php
class FrontController {
    var $_class_name = 'FrontController';
    var $requestedPageController;
    var $requestedAction;
    var $requestedParams;
    var $isAuthenticated = true;
    var $noRequest;
    
    function __construct(){
		if ( isset( $_POST['controller'])){
			$this->postRequest();	
		} else if ( isset( $_GET['controller'])){
			$this->getRequest();
		} else {
			$this->noRequest = true;
		}
    }
    function execute(){
    	if ( $this->noRequest) return 'no controller set in GET or POST array';
        $this->authenticate();
        if ($this->isAuthenticated){
			$r =& getRenderer();
            $page   = $this->requestedPageController;
            $action = $this->requestedAction;
            $params = $this->requestedParams;
            $application_html = $page->execute( $action, $params);
            return $r->template( 'template/gtd_main_template.html', 
            						array( 	'main-application'=>$application_html,
            								'msg'=>$r->_dumpMessages()));
        } else {
			return $this->login();
        }
    }
    function getRequest(){
    	$path = 'controller/'.$_GET['controller'].'.php';
		if( !file_exists($path)) bail( 'requested controller "'.$_GET['controller'].'" does not exist.');
        require_once( $path);
        $this->requestedPageController = new $_GET['controller'];
        $this->requestedAction = 'get';
        $this->requestedParams = $_GET;
        unset($this->requestedParams['controller']);
    }   
    function postRequest(){
    	$path = 'controller/'.$_POST['controller'].'.php';
		if( !file_exists($path)) bail( 'requested controller "'.$_POST['controller'].'" does not exist.');
        require_once('controller/'.$_POST['controller'].'.php');
        $this->requestedPageController = new $_POST['controller'];
        $this->requestedAction = 'post';
        $this->requestedParams = $_POST;
        unset($this->requestedParams['controller']);
    }  
    function authenticate(){
        //  Me aither yeh fuukken bastard yeu!
    }
	function login(){
    	// Ah steel wunt deu eet yeu fuk
    }
}
?>	