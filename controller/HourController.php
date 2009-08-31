<?php
class HourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	var $after_filters = array( 'save_posted_records' => array('create','update','destroy') );
	
    function __construct(){
        parent::__construct();
    }
    function index( $params ){
    
    }
    function edit( $params ){
    	$d = $this->data;
        $d->hour = new Hour( $params['id']);
	    $d->estimate = new Estimate( $d->hour->get('estimate_id'));
        $d->project = new Project( $d->estimate->get('project_id'));
    }
    function update(){
    }
    function post(){
    	$this->redirectTo(array('action' => 'edit'));
    }
    function show(){
    }
    function add(){
    }
    function create(){
    }
    function destroy(){
    }
}
?>
