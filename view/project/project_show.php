<?php
function projectShow($d){
	$r =& getRenderer();
	$select_project = $r->view( 'jumpSelect', $d->project);
	$project_info = $r->view('projectInfo', $d->project);
	$contact_table = $r->view('contactTable',$d->project->getContacts());
	$estimate_table = $r->view('estimateTable', $d->project->getEstimates());

	return	array(
		'title' => $d->project->getName(),
		'controls' => $select_project,
		'body' => $project_info.$contact_table.$estimate_table
		);
}
?>