<?php
class HoursByEstimate extends PageController {
    var $_class_name = 'HoursByEstimate';
    
    function HoursByEstimate() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r = getRenderer();
		$p = new Project($get['id']);
		$estimates = $p->getEstimates();
        $html = $r->view('hoursByEstimate', $estimates, array('id'=>'test'));
		$message = 'this is the estimate items and logged hours';
       	$name = $p->getName(); 
        return $r->template('template/test_template.html',
        					array(
        					'name'=>$name,
        					'body'=>$html,
							'message'=>$message
        					));
    }
}
?>
