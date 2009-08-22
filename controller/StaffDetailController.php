<?php
/**
  	StaffDetail
    
    Displays details about a particular staff
   
   $params options array:
    -<b>contact_id</b> id of the staff that we want to see details for
              
    @return html
    @package controller

*/


class StaffDetailController extends PageController {
    var $_class_name = 'StaffDetail';

    function __construct(){
        parent::__construct();
    }
    function get( $params = array()){
        $r =& getRenderer();
		if( !$params['id']) {
			bail('can has Staff id? kthx');
		}
        $staff = new Staff($params['id']);
        $staff_detail = $r->view( 'staffDetail', $staff);
        $project_table = $r->view( 'projectTable', $staff->getProjects());
   
        return $r->template('template/standard_inside.html',
                            array(
                            'title'=>$staff->getName(),
                            'controls'=>$r->view( 'jumpSelect', $staff),
                            'body'=>$staff_detail.$project_table
                            ));
    }        
}
?>
