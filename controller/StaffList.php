<?php
class StaffList extends PageController {
    var $_class_name = 'StaffList';

    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
        $finder = new Staff();
        $staff = $finder->find();

        $html = $r->view('staffTable', $staff, array('id'=>'staff'));
          
        return $r->template('template/test_template.html',
                            array(
                            'name'=>$name,
                            'body'=>$html
                            ));
    }        
}
?>
