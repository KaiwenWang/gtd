<?php
function projectShow($d){
	$r =& getRenderer();
	$select_project = $r->view( 'jumpSelect', $d->project);

	$project_info = $r->view('projectInfo', $d->project);
	$project_edit_form = $r->view('projectEditForm', $d->project);
	
	$editable_project_info = $r->view('jsSwappable', 'Project Info', array( $project_info, $project_edit_form));

	$estimate_new_form = $r->view('estimateNewForm', $d->estimate);
	$hour_new_form = $r->view('hourNewForm', $d->hour, array('project_id'=>$d->project->id));
	$estimate_table = $r->view('estimateTable', $d->project->getEstimates());
	

	return	array(
		'title' => $d->project->getName(),
		'controls' => $select_project,
		'body' => 	$editable_project_info
					.$estimate_new_form
					.$hour_new_form
					.$estimate_table
		);
}
?>
