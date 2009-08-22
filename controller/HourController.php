<?php
class HourController extends PageController {
    var $_class_name = 'HourEdit';
		var $before_actions = array( 'get_posted_records' => array('create','update','destroy') );
		var $after_actions = array( 'save_posted_records' => array('create','update','destroy') );
    function __construct(){
        parent::__construct();
    }
    function index( $params ){
    
    }
    function edit( $params ){
        $h = new Hour( $params['id']);
	    	$e = new Estimate( $h->get('estimate_id'));
        $p = new Project( $e->get('project_id'));
        return $this->display( array( 'project' => $p, 'estimate' => $e, 'hour' => $h )); 
    }
    function update(){
    }
    function post() {
    }
    function show(){
    }
    function new(){
    }
    function create(){
    }
    function destroy(){
    }
}
?>
