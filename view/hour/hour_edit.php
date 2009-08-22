<?php
function hourEdit($params){
    extract( $params );

    $title = $project->getName();

    $controls = $r->view( 'jumpSelect', $estimate, array('project_id'=>$estimate->getData('project_id')));

    $project_info	= $r->view( 'projectInfo', $project, array( 'class'=>'float-left'))
    							. $r->view( 'estimateInfo', $estimate, array( 'class'=>'float-left'));
    			
    $hour_edit_form = $r->view( 'hourEditForm', $hour, array('class'=>'clear-left'));

    $hour_table = $r->view('hourTable', $estimate->getHours(), array('title'=>'Hours for '.$estimate->getName()));

    $estimate_table = $r->view('estimateTable', $project->getEstimates());

    return array(   'title' 	=> $title,
                    'controls'=> $controls,
                    'body' 		=> $project_info.$hour_edit_form.$hour_table.$estimate_table
    								);
}
?>
