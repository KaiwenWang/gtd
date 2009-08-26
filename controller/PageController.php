<?php
class PageController {
    var $authentication_level = array( 'staff');
    var $_class_name = 'PageController';
    var $method;
    var $current_action;
    var $params = array();
    var $posted_records = array();
    var $response;
    var $data;
    var $display_options = array();
 	var $before_actions = array( 'get_posted_records' => array('create','update','destroy') );
	var $after_actions = array( 'save_posted_records' => array('create','update','destroy') );
    
    function __construct(){
        $this->data = new Collection();
    } 
    function execute( $action, $params = array()){
        $this->params = $params;
    	$this->current_action = $action;
    	$this->executeActions();
		$this->response = $this->display();
    	if ( $this->response) return $this->response;
    	bail( 'This action was valid, but did not render any html.');
    }
    function executeActions( ){
    	if ( !method_exists( $this, $this->current_action)) bail( 'non-existent action requested: '.$action);
   		$this->executeBeforeActions();
		$this->{$this->current_action}( $this->params);
		$this->executeAfterActions();
		$this->nextAction();
    }
    function executeBeforeActions(){
    	$beforeAction = 'before'.ucfirst( $action);
    	if ( method_exists( $this, $beforeAction)) $this->$beforeAction();
    }
    function executeAfterActions(){
    	$afterAction = 'after'.ucfirst( $action);
    	if ( method_exists( $this, $afterAction)) $this->$afterAction();
    }
    function nextAction(){
    	if(!$this->redirect_options) return;
    	$this->current_action = $this->redirect_options['action'];
    	$this->redirect_options = array();
    	$this->executeActions();
    }
    function redirectTo( $o = array()){
    	$this->redirect_options = $o;
    }    
    protected function beforePost( ){
    	$record_set = $this->params['ActiveRecord'];
			foreach($record_set as $class_name => $object_set){
				foreach( $object_set as $id => $updated_fields){
					if( $id == 'new') bail('Can\'t create new objects yet');
					$obj = new $class_name( $id);
					$obj->mergeData( $updated_fields);
					$this->posted_records[]=$obj;
				}
			}
    }
    function setMethod( $method ){
        $this->method = $method;
    }
    protected function afterPost( ){
			foreach( $this->posted_records as $obj) $obj->save();
			if( $this->params('redirect')) {
				header('Location: '.$this->params('redirect').'');
				die();
			}
    }
    protected function params( $key ){
        if( isset( $this->params[$key]) && $this->params[$key]) {
            return $this->params[$key];
        }
        return false;
    }
    function template_path_for( $action){
        return 'template/standard_inside.html';
    }
    function display(){
        $r = getRenderer( );
        
        isset( $this->display_options['action'])? $action = $this->display_options['action'] 
					                            : $action = $this->current_action;

        $view_name = strtolower( str_replace( "Controller", "", get_class( $this ))) . ucwords( $action );

        return $r->template( $this->template_path_for( $action), $r->view( $view_name, $this->data ));
    }
}
?>
