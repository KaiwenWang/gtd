<?php
class FrontController {
    private $router;
    private $page;
    
    function __construct(){
        $this->router = Router::singleton();
        $this->page = $this->getPageController();
    }
    function execute(){
        $r = getRenderer();
		$this->authenticate() ?	$response = $this->page->execute($this->router->action, 
                                  		               					 $this->router->params( ))
                              :	$response = $this->renderLoginScreen();

		if (isset($this->router->params['ajax_target_id'])) return $response['body'];
        $response =  array_merge(
                               $response,
                               array( 
        							 'msg'=>$r->_dumpMessages(),
        							 'login'=>$this->renderLoginWidget()
        	    				));
        return $r->template( 'template/gtd_main_template.html', 
                                $response
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
   		if ( !Session::sessionExists()) return false;
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
		return $login->execute('widget', array( 'partial'=>true ));    	
    }
}
?>
