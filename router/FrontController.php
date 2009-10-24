<?php
class FrontController {
    var $requestedPageController;
    var $router;
    
    function __construct(){
        $this->router = Router::singleton();
        require_once( $this->router->controller_path( ));
        class_exists($this->router->controller)	? $this->page = new $this->router->controller( )
        										: bail("Requested controller <b>{$this->router->controller}</b> does not exist, but controller path <b>{$this->router->controller_path()}</b> <i>does</i> exist.  Maybe the controller name is misspelled?");
    }
    function execute(){
		$r =& getRenderer();
        $application_html = $this->page->execute($this->router->action, 
                                                 $this->router->params( ));
		require_once('controller/AuthenticateController.php');
		$login = new AuthenticateController();
		$login_message = $login->execute('widget');
        return $r->template( 'template/gtd_main_template.html', 
        					  array( 'main-application'=>$application_html,
        							 'msg'=>$r->_dumpMessages(),
        							 'login'=>$login_message)
        					);
    }  
}
?>