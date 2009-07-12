<?php
/**
  	StaffDetail
    
    Displays details about a particular staff
   
   $get options array:
    -<b>contact_id</b> id of the staff that we want to see details for
              
    @return html
    @package controller

*/


class StaffDetail extends PageController {
    var $_class_name = 'StaffDetail';

    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
		if( !$get['staff_id']) {
			$r->msg('bad','can has Staff id? kthx');
			return;
		}
        $staff = new Staff($get['staff_id']);
        $html = $r->view('staffDetail', $staff);
          
        return $html;
    }        
}
?>
