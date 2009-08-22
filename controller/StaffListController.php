<?php
class StaffListController extends PageController {
    var $_class_name = 'StaffList';

    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
        $staff = getAll( 'Staff');
        $html = $r->view( 'staffTable', $staff);
        return $r->template('template/standard_inside.html',
                            array(
                            'title'=>'Listing All Staff',
                            'controls'=>'',
                            'body'=>$html
                            ));
    }        
}
?>
