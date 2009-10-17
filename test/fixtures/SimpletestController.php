<?php

class SimpletestController extends PageController {
    public $filter_collection_name = 'SimpleTestFilterCollection';
    protected $before_filters = array(  'local_filter' => array( 'index'),
                                        'test_filter_collection'=> array( 'test_filter_collection_action'),
                                        'get_posted_records'=>array( 'count_new_records')
                                     );
    protected $after_filters = array( );

    function local_filter( ){
        $this->filter_worked = true;
    }
    function index( $params ) {
        if( $this->filter_worked ) {
            $this->local_filters_okay = true;
        }
    }
    function test_filter_collection_action( ){
    }
    function viewless_action( $params ) {
        $this->disableResponse( );
    }

    function count_new_records( $params ) {
        
    }
}



?>
