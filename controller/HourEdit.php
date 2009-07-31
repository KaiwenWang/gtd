<?php
class HourEdit extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
        $h = new Hour( $params['id']);
		
		if ( $h->getData('estimate_id')){
	        $e = new Estimate( $h->getData('estimate_id'));
	        $title = $e->getName();
	        $controls['Estimates in this Project'] .= $r->view( 'jumpSelect', $e,
	        													array('project_id'=>$e->getData('project_id')));
			$hour_table = $r->view('hourTable', $e->getHours(), array('title'=>'Hours for '.$e->getName()));
			$info = $r->view('projectInfo', new Project( $e->get('project_id')), array( 'class'=>'float-left'));
			$info .= $r->view( 'estimateInfo', $e,  array( 'class'=>'float-left'));
		} elseif ( $h->getData('support_contract_id')){
			$s = new SupportContract( $h->getData('support_contract_id'));
	        $title = $s->getName();
			$hour_table = $r->view('hourTable', $s->getHours());
			$info = $r->view('supportContractInfo', $s);		
		}

		$form = $r->view( 'hourEditForm', $h, array('class'=>'clear-left'));

        return $r->template('template/standard_inside.html',
                            array(
                            'title' 	=> $title,
                            'controls'	=> $r->view( 'basicList', $controls),
                            'body' 		=> $info.$form.$hour_table
                            ));
    }

    function post( $posted_object ) {

    }
}
?>