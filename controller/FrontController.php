<?php
class FrontController {
    var $_class_name = 'FrontController';
    var $requestedPageController;
    var $requestedAction;
    var $requestedParams;
    var $isAuthenticated = true;
    var $router;
    
    function __construct(){
        $this->router = Router::singleton();
        require_once( $this->router->controller_path( ));
        $this->page = new $this->router->controller( );
    }
    function execute(){
        $this->authenticate();
        if ($this->isAuthenticated){
			$r =& getRenderer();
            $application_html = $this->page->execute($this->router->action, 
                                                     $this->router->params( ));
            return $r->template( 'template/gtd_main_template.html', 
            					  array( 'main-application'=>$application_html,
            							 'msg'=>$r->_dumpMessages())
            					);
        } else {
			return $this->login();
        }
    }  
    function authenticate(){
        //  Me aither yeh fuukken bastard yeu!
    }
	function login(){
    	// Ah steel wunt deu eet yeu fuk
    }
}
?>
