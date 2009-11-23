<?php
function projectShow($d){
	$r =& getRenderer();

	$select_project = 		$r->view( 'jumpSelect', $d->project);


	$editable_project_info= $r->view( 'jsSwappable',
									  'Project Info',
					 				   array(
						 				$r->view( 'projectInfo', $d->project),
										$r->view( 'projectEditForm' , $d->project)
										)
									);

	$hidden_forms = $r->view('jsHideable',array(
						'Create New Estimate'=> $r->view( 'estimateNewForm', 
														  $d->estimate
														),								
						'Log Hours'	=> $r->view( 'hourNewForm', 
												 $d->hour, 
												 array('project_id'=>$d->project->id)
												)
					));


	$estimate_table = $r->view('estimateTable', $d->project->getEstimates());
	

	return	array(
		'title' => $d->project->getName(),
		'controls' => $select_project,
		'body' => 	$editable_project_info
					.$hidden_forms
					.$estimate_table
		);
}
?>
