<?php
class EstimateDetail extends PageController {
    var $_class_name = 'EstimateList';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();

		$estimate = new Estimate( $params['estimate_id']);
        $select_estimate = $r->objectSelect( $estimate, 
                                             array('name'=>'estimate_id'),
                                             array( 'project_id'=>$estimate->getData( 'project_id')));
		$select_estimate .= $r->submit();
		$select_estimate = $r->form( 'get', 'EstimateDetail', $select_estimate);

        
		$estimate_info = $r->view('estimateInfo', $estimate);
        $hour_table = $r->view('hourTable',$estimate->getHours());

        return $r->template('template/standard_inside.html',
                            array(
                            'title' => $estimate->getName(),
                            'controls' => $select_estimate,
                            'body' => $estimate_info.$hour_table
                            ));
    }
}
?>
