<?php
class PageController extends Collection {
    var $current_action;
    var $params = array();
	var $data;
    var $response;

    var $display_options = array();

    var $filter_sequences = array();
        
    var $filter_collection_name = 'defaultFilterCollection';
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	var $after_filters = array( 'save_posted_records' => array('create','update','destroy') );
    var $around_filters = array();

    function __construct(){
        $this->data = new Collection();
        $this->loadFilterCollection();
        $this->generateFilterSequences();
    } 
    function execute( $action, $params = array()){
        $this->params = $params;
    	$this->current_action = $action;
    	
    	$this->executeActionChain();
    	
		$this->response = $this->renderResponse();
    	if ( $this->response) return $this->response;
     	bail( 'This action was valid, but did not render any html, and was not set to redirect to another action');
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

		$this->nextAction();
    }
    function nextAction(){
    	if(!$this->redirect_options) return;
    	$this->current_action = $this->redirect_options['action'];
    	$this->redirect_options = array();
    	$this->executeActions();
    }
    function renderResponse(){
        $r = getRenderer( );
        
        isset( $this->display_options['action'])? $action = $this->display_options['action'] 
					                            : $action = $this->current_action;

        $view_name = strtolower( str_replace( "Controller", "", get_class( $this ))) . ucwords( $action );

        return $r->template( $this->template_path_for( $action), $r->view( $view_name, $this->data ));
    }    
    function redirectTo( $o = array()){
    	$this->redirect_options = $o;
    }    
    private function template_path_for( $action){
        return 'template/standard_inside.html';
    }
    protected function executeFilterSequence( $filter_sequence_name){
    	$filter_sequence = $this->filter_sequences_for[$this->current_action][$filter_sequence_name];
    	foreach ($filter_sequence as $filter){
    		method_exists( $this->filterCollection, $filter)	? $this->filterCollection->$filter()
    										: bail("Filter <b>$filter</b> does not exist");
    	}
    	
    };    
    private function generateFilterSequences(){
    	$this->filter_sequences_for = array();
    	$filter_sequences = array('before_filters','after_filters','around_filters');
    	foreach( $filter_sequences as $filter_sequence_name){}
	    	foreach( $filter_sequence_name as $filter => $action_set){
				foreach( $action_set as $action ){
					if( array_key_exists($this->current_action, $action_set) ) $this->filter_sequences_for[$action][$filter_sequence_name][] = $filter;
				}
	    	}
    	}
    }
    private function LoadFilterCollection(){
		require_once('controller/filter/'.$this->filter_collection_name);
    	$this->filter_collection = new $this->filter_collection_name;
    	$this->filter_collection->controller = $this;
    }
}
?>
