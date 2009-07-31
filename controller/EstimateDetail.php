<?php
class EstimateDetail extends PageController {

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();

		$e = new Estimate( $params['id']);
		$controls = $r->view( 'jumpSelect', $e, array('project_id'=>$e->getData('project_id')));
		$p_info = $r->view( 'projectInfo', new Project($e->getData('project_id')),  array( 'class'=>'float-left'));
		$e_info = $r->view( 'estimateInfo', $e, array( 'class'=>'float-left'));
        $hour_table = $r->view('hourTable', $e->getHours(), array('title'=>'Hours for '.$e->getName()));

        return $r->template('template/standard_inside.html',
                            array(
                            'title' => $e->getName(),
                            'controls'	=> $controls,
                            'body' => $p_info.$e_info.$hour_table
                            ));
    }
}
?>
