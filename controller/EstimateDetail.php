<?php
class EstimateDetail extends PageController {

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();

		$estimate = new Estimate( $params['id']);
		$select_estimate = $r->view( "jumpSelect", $estimate, array('project_id'=>$estimate->getData( 'project_id')));

        
		$estimate_info = $r->view( 'estimateInfo', $estimate);
        $hour_table = $r->view( 'hourTable', $estimate->getHours());

        return $r->template('template/standard_inside.html',
                            array(
                            'title' => $estimate->getName(),
                            'controls' => $select_estimate,
                            'body' => $estimate_info.$hour_table
                            ));
    }
}
?>
