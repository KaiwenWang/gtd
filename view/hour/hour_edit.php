<?php
function hourEdit($p){
	$r = getRenderer( );

    $title = $p->project->getName();

    $controls = $r->view( 'jumpSelect', $p->estimate, array('project_id'=>$p->estimate->getData('project_id')));

    $project_info	= $r->view( 'projectInfo', $p->project, array( 'class'=>'float-left'));
    			
    $hour_edit_form = $r->view( 'hourEditForm', $p->hour, array('class'=>'clear-left'));

    $hour_table = $r->view('hourTable', $p->estimate->getHours(), array('title'=>'Hours for '.$p->estimate->getName()));

    $estimate_table = $r->view('estimateTable', $p->project->getEstimates());

    return array(   'title' 	=> $title,
                    'controls'	=> $controls,
                    'body' 		=> $project_info.$hour_edit_form.$hour_table.$estimate_table
    								);
}
?>
