<?php
class FrontController {
    var $_class_name = 'FrontController';
    var $requestedPageController;
    var $requestedAction;
    var $requestedParams;
    var $isAuthenticated = true;
    
    function __construct(){
		if ( isset( $_POST['controller'])){
			$this->createRequest( 'post');	
		} else if ( isset( $_GET['controller'])){
			$this->createRequest( 'get');
		} else {
			$_REQUEST['controller'] = 'HomePage';
			$this->createRequest( 'get');
		}
    }
    function execute(){
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
    function createRequest( $action = 'get'){
    	$path = 'controller/'.$_REQUEST['controller'].'.php';
		if (!file_exists( $path)) bail( 'requested controller "'.$_REQUEST['controller'].'" does not exist.');
        require_once( $path);
        $this->requestedPageController = new $_REQUEST['controller'];
        $this->requestedAction = $action;
        $this->requestedParams = $_REQUEST;
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