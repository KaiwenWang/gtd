<?php
class PageController{

    public $params = array();
	public $data;
	public $display_options = array( 'controller'=>'', 'action'=>'', 'view'=>'');

	protected $authentication_type = 'staff'; // staff, public
    protected $filter_collection_name = 'defaultFilterCollection';
 	protected $before_filters = array();
	protected $after_filters = array();
    protected $around_filters = array();

    private $filter_sequences = array();
    private $current_action;
    private $response_html;
    private $responseEnabled = true;
    private $render_partial = false;
    
    function __construct(){
        $this->data = new Collection();
        $this->loadFilters();
        $this->generateFilterSequences();
    } 
    function execute( $action, $params = array()){
        $this->params = $params;
    	$this->current_action = $action;
    	if( isset($params['partial']) && $params['partial']) $this->render_partial = true;
    	
    	$this->executeActionChain();

		$this->response = $this->renderResponse();
    	if ( $this->response) return $this->response;
        if( $this->responseEnabled ) bail( 'This action was valid, but did not render any html, and was not set to redirect to another action. Use $this->disableResponse( ) if this is the desired behavior');
    }
	function params( $key ){
        if( isset( $this->params[$key]) && $this->params[$key]) {
            return $this->params[$key];
        }
        return false;
    }    
    function executeActionChain( ){
    	if ( !method_exists( $this, $this->current_action)) bail( 'non-existent action requested: '.$action);
    	
  		$this->executeFilterSequence('around_filters');
   		$this->executeFilterSequence('before_filters');
		$this->{$this->current_action}( $this->params);
   		$this->executeFilterSequence('after_filters');
  		$this->executeFilterSequence('around_filters');

		$this->redirect();
    }
    private function redirect(){
    	if( isset( $this->redirect_url) && $this->redirect_url){
    		header('location: ' . $this->redirect_url);
    		exit();
    	} else{
			return;
    	}
		bail('php redirect is stupid.');
    }
    protected function redirectTo( $o = array()){
    	$router = Router::singleton();
    	$r = getRenderer();
    	$o['controller']	? $controller = $o['controller']
    						: $controller = $router->controller_prefix;
    	$o['action']	? $action = $o['action']
    					: $action = 'index';
		$o['action'] = $action;
    	unset($o['controller']);
    	if( !$o['action']) bail('action not specified in redirect request.');
    	$this->redirect_url = $r->url( $controller, $o);
    }
    function renderResponse(){
        if ( !$this->responseEnabled ) return false;
        $r = getRenderer();
        
        $this->display_options['action']	? $action = $this->display_options['action'] 
					                        : $action = $this->current_action;

        $this->display_options['controller']? $view_name = $this->getViewNameFor( $this->display_options['controller'], $action)
					                        : $view_name = $this->getViewNameFor( get_class($this), $action);
					                        	
		if ($this->display_options['view']) $view_name = $this->display_options['view'];

		if ($this->render_partial) {
			$response = $r->view( $view_name, $this->data );
			return $response['body'];
		}
        return $r->template( $this->template_path_for( $action), $r->view( $view_name, $this->data ));
    }
    function disableResponse( ) {
        $this->responseEnabled = false;

    }
    function enableResponse( ) {
        $this->responseEnabled = true;
    }
    function isResponseEnabled( ) {
        $this->responseEnabled;
    }
    function loadFilters(){
        $this->loadFilterCollection( );

    }
    function getAuthenticationType(){
    	return $this->authentication_type;
    }
    protected function executeFilterSequence( $filter_sequence_name){
    	if ( !isset( $this->filter_sequences_for[$this->current_action][$filter_sequence_name])) return;
    	$filter_sequence = $this->filter_sequences_for[$this->current_action][$filter_sequence_name];
    	if (!$filter_sequence) return;
    	foreach ($filter_sequence as $filter){
            if ( method_exists( $this, $filter)) {
                $this->$filter();
            } elseif ( method_exists( $this->filter_collection, $filter)) {
                
                $this->filter_collection->$filter();
            } else {
    	        bail("Filter <b>$filter</b> does not exist");
            }
    	}	
    } 

    private function generateFilterSequences(){
    	$this->filter_sequences_for = array();
    	$filter_sequences = array('before_filters','after_filters','around_filters');
    	foreach( $filter_sequences as $filter_sequence_name){
	    	foreach( $this->$filter_sequence_name as $filter => $action_set){
				foreach( $action_set as $action ){
					$this->filter_sequences_for[$action][$filter_sequence_name][] = $filter;
				}
	    	}
    	}
    }
    private function loadFilterCollection(){
		require_once('controller/filter/'.$this->filter_collection_name.'.php');
    	$this->filter_collection = new $this->filter_collection_name( $this);
    }
    private function template_path_for( $action){
        return 'template/standard_inside.html';
    }
    private function getViewNameFor( $controller, $action){
    	return strtolower( str_replace( "Controller", "", $controller)) . ucwords( $action );
    }
}
?>
