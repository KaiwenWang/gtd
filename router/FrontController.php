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
        class_exists($this->router->controller)	? $this->page = new $this->router->controller( )
        										: bail("Requested controller <b>{$this->router->controller}</b> does not exist, but controller path <b>{$this->router->controller_path()}</b> <i>does</i> exist.  Maybe the controller name is misspelled?");
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
	function login(){
    	// Ah steel wunt deu eet yeu fuk
    }
    function authenticate(){
        //  Me aither yeh fuukken bastard yeu!
    }
}
?>
