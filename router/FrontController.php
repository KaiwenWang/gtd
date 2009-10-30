<?php
class FrontController {
    private $router;
    private $page;
    
    function __construct(){
        $this->router = Router::singleton();
        $this->page = $this->getPageController();
    }
    function execute(){
		$r =& getRenderer();
		$this->authenticate() ?	$application_html = $this->page->execute(	$this->router->action, 
                                  		               						$this->router->params( ))
                              :	$application_html = $this->renderLoginScreen();

        return $r->template( 'template/gtd_main_template.html', 
        					  array( 'main-application'=>$application_html,
        							 'msg'=>$r->_dumpMessages(),
        							 'login'=>$this->renderLoginWidget())
        					);
    }
   	private function getPageController(){
   		require_once( $this->router->controller_path( ));
        return class_exists($this->router->controller)	? new $this->router->controller( )
        												: bail("Requested controller <b>{$this->router->controller}</b> does not exist, but controller path <b>{$this->router->controller_path()}</b> <i>does</i> exist.  Maybe the controller name is misspelled?");
   	}
   	private function authenticate(){
   		$auth_type = $this->page->getAuthenticationType();
   		
   		if ( $auth_type == 'public') return true;
   		if ( $auth_type == Session::getUserType()) return true;
		return false;
   	}
   	private function renderLoginScreen(){
		require_once('controller/AuthenticateController.php');
		$login = new AuthenticateController();
		return $login->execute('login');    	   		
   	}
    private function renderLoginWidget(){
		require_once('controller/AuthenticateController.php');
		$login = new AuthenticateController();
		return $login->execute('widget');    	
    }
}
?>