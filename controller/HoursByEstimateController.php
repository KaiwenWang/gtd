<?php
/**
    HoursByEstimate
    
    Displays a list of the estimate line items associated with a project and as sublist the logged hours associated with the Estimates.
        
    $get options array:
    -<b>project_id</b> id of the project that we want to see the hours associated with it
      
    @return html
    @package controller
*/

class HoursByEstimate extends PageController {
    var $_class_name = 'HoursByEstimate';
    
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
        if (!$get['project_id']) {
			$r->msg('bad','You need to provide a project_id ');
			return;
		}
		$p = new Project($get['project_id']);
		$estimates = $p->getEstimates();
        $html = $r->view('hoursByEstimate', $estimates, array('id'=>'test'));

		return $html;
    }
}
?>
