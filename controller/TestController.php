<?php
class TestController extends PageController {
    
    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
        $

        return $r->template('template/standard_inside.html',
        					array(
        					'title'=>$name,
        					'body'=>$html
        					));
    }
    function post( $post){
    	
    }
}
?>
