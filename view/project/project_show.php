<?php
function projectShow($d){
	$r =& getRenderer();
	$select_project = $r->view( 'jumpSelect', $d->project);

	$project_info = $r->view('projectInfo', $d->project);
	//$estimate_new = $r->view('estimateNewForm', $d->estimate);
	$hour_new_form = $r->view('hourNewForm', $d->hour, array('project_id'=>$d->project->id));
	$estimate_table = $r->view('estimateTable', $d->project->getEstimates());
	

	return	array(
		'title' => $d->project->getName(),
		'controls' => $select_project,
		'body' => 	$project_info
					.$hour_new_form
					.$estimate_table
		);
}
?>
