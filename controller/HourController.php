<?php
class HourController extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function edit( $params){
        $h = new Hour( $params['id']);
	    $e = new Estimate( $h->get('estimate_id'));
        $p = new Project( $e->get( 'project_id'));
        return $this->display( array( 'project' => $p, 'estimate' => $e )) ;
    
    }
    function post( $posted_object ) {

    }
}
?>
