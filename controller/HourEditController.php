<?php
class HourController extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function edit( $params){
        $r =& getRenderer();
        $h = new Hour( $params['id']);
		
		if ( $h->getData('estimate_id')){
	        $e = new Estimate( $h->get('estimate_id'));
	        $title = $e->getName();
	        $controls = $r->view( 'jumpSelect', $e, array('project_id'=>$e->getData('project_id')));
			$hour_table = $r->view('hourTable', $e->getHours(), array('title'=>'Hours for '.$e->getName()));
            $p = new Project( $e->get( 'project_id'));
            $estimate_table = $r->view('estimateTable', $p->getEstimates());
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
                            'controls'	=> $controls,
                            'body' 		=> $info.$form.$hour_table.$estimate_table
                            ));
    }

    function post( $posted_object ) {

    }
}
?>
