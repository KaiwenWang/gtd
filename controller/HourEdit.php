<?php
class HourEdit extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
        $h = new Hour( $params['id']);
        $e = new Estimate($h->getData('estimate_id'));
		$form = $r->view( 'hourEdit', $h);

        return $r->template('template/standard_inside.html',
                            array(
                            'title' 	=> 'Create/Edit Hour',
                            'controls'	=> $r->view( 'jumpSelect', $h, array('estimate_id'=>$e->id)).
                            				$r->view( 'jumpSelect', $e, array('project_id'=>$e->getData('project_id'))),
                            'body' 		=> $form
                            ));
    }

    function post( $posted_object ) {

    }
}
?>
