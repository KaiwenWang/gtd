<?php
function hourEdit($p){
    extract( $p );
    $r =& getRenderer();
    #$project->getName( );
    $title = $e->getName();
    $controls = $r->view( 'jumpSelect', $e, array('project_id'=>$e->getData('project_id')));
    $hour_table = $r->view('hourTable', $e->getHours(), array('title'=>'Hours for '.$e->getName()));
    $estimate_table = $r->view('estimateTable', $p->getEstimates());
    $info = $r->view('projectInfo', new Project( $e->get('project_id')), array( 'class'=>'float-left'));
    $info .= $r->view( 'estimateInfo', $e,  array( 'class'=>'float-left'));
    $form = $r->view( 'hourEditForm', $h, array('class'=>'clear-left'));

    return array(   'title' 	=> $title,
                    'controls'	=> $controls,
                    'body' 		=> $info.$form.$hour_table.$estimate_table
                    ));
}
?>
