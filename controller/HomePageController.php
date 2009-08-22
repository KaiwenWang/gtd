<?php
class HomePageController extends PageController {
    var $_class_name = 'HomePage';

    function __construct(){
        parent::__construct();
    }
    function get( $params = array()){
        $r =& getRenderer();
        return $r->template('template/standard_inside.html',
                            array(
                            'title'=>'All yr Defaults arr belongs to us.',
                            'controls'=>'',
                            'body'=>''
                            ));
    }        
}
?>
