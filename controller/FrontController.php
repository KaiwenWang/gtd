<?php
class FrontController {
    var $_class_name = 'FrontController';
    var $requestedPageController;
    var $requestedAction;
    var $requestedParams;
    var $isAuthenticated = true;
    var $noResponse;
    
    function FrontController() {
        $this->__construct();
    }
    function __construct(){
		if ( isset( $_POST['controller'])){
			$this->postRequest();	
		} else if ( isset( $_GET['controller'])){
			$this->getRequest();
		} else {
			$this->noResponse = true;
		}
    }
    function execute(){
    	if ( $this->noResponse) return 'no response';
        $this->authenticate();
        if ($this->isAuthenticated){
			$r = getRenderer();
            $page   = $this->requestedPageController;
            $action = $this->requestedAction;
            $params = $this->requestedParams;
            $application_html = $page->execute( $action, $params);
            $msg = getMessage();
            return $r->template( 'template/gtd_main_template.html', 
            						array( 	'main-application'=>$application_html,
            								'msg'=>$msg));
        } else {
			return $this->login();
        }
    }
    function getRequest(){
        require_once('controller/'.$_GET['controller'].'.php');
        $this->requestedPageController = new $_GET['controller'];
        $this->requestedAction = 'get';
        $this->requestedParams = $_GET;
        unset($this->requestedParams['controller']);
    }   
    function postRequest(){
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