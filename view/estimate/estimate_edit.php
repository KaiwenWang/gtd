<?php
function estimateEdit($d){
$r =& getRenderer();
	$select_project = $r->view( 'jumpSelect', $d->project);

	$project_info = $r->view('projectInfo', $d->project);
//	$contact_table = $r->view('contactTable',$d->project->getContacts());
	$estimate_edit_form = $r->view('estimateEditForm', $d->estimate);
	$estimate_table = $r->view('estimateTable', $d->project->getEstimates());

	return	array(
		'title' => $d->project->getName(),
		'controls' => $select_project,
		'body' => 	$project_info
					.$estimate_edit_form
					.$estimate_table
		);

}
?>