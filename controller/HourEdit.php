<?php
class HourEdit extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
        $h = new Hour( $params['id']);

		$controls['Hours in this Estimate'] = $r->view( 'jumpSelect', $h, array('estimate_id'=>$h->getData('estimate_id')));

		$form = $r->view( 'hourEditForm', $h);

		if ( $h->getData('estimate_id')){
	        $e = new Estimate( $h->getData('estimate_id'));
	        $controls['Estimates in this Project'] .= $r->view( 'jumpSelect', $e,
	        													array('project_id'=>$e->getData('project_id')));
			$hour_table = $r->view('hourTable', $e->getHours(), array('title'=>'Hours for '.$e->getName()));

		} elseif ( $h->getData('support_contract_id')){
			$s = new SupportContract( $h->getData('support_contract_id'));
			$hour_table = $r->view('hourTable', $s->getHours());
		}
		
        return $r->template('template/standard_inside.html',
                            array(
                            'title' 	=> 'Create/Edit Hour',
                            'controls'	=> $r->view( 'basicList', $controls),
                            'body' 		=> $hour_table.$form
                            ));
    }

    function post( $posted_object ) {

    }
}
?>