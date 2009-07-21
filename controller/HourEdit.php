<?php
class HourEdit extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
        $h = new Hour( $params['id']);
		$controls = $r->view( 'jumpSelect', $h, array('estimate_id'=>$e->id));
		$form = $r->view( 'hourEditForm', $h);
		if ( $h->getData('estimate_id')){
	        $e = new Estimate( $h->getData('estimate_id'));
	        $controls .= $r->view( 'jumpSelect', $e, array('project_id'=>$e->getData('project_id')));
			$table = $r->view('hourTable', $e->getHours(), array('title'=>'Hours for '.$e->getName()));
		} elseif ( $h->getData('support_contract_id')){
			$s = new SupportContract( $h->getData('support_contract_id'));
			$table = $r->view('hourTable', $s->getHours());
		}
		
        return $r->template('template/standard_inside.html',
                            array(
                            'title' 	=> 'Create/Edit Hour',
                            'controls'	=> $controls,
                            'body' 		=> $table.$form
                            ));
    }

    function post( $posted_object ) {

    }
}
?>