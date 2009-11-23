<?php
function estimateEdit($d){
	$r =& getRenderer();
	$select_project = $r->view( 'jumpSelect', $d->project);

	$editable_project_info= $r->view(	'jsSwappable',
										'Estimate Info',
					 					array(
						 					$r->view( 'estimateInfo', $d->estimate),
											$r->view( 'estimateEditForm', $d->estimate)
										)
									);

	$hidden_forms = $r->view('jsHideable',array(
						'Create New Estimate'=> $r->view(	
													 	 'estimateNewForm', 
														 $d->estimate
														),
														
						'Log Hours'	=> $r->view(
												'hourNewForm', 
												$d->new_hour, 
												array('project_id'=>$d->project->id)
											   )
					));
					
	$d->hours 	? $hours_table = $r->view('hourTable', $d->hours)
				: $hours_table = '
								<div class="empty-table-message">
									No hours have been logged against this estimate.
								</div>
								';
								
	$estimate_table = $r->view('estimateTable', $d->estimates);

	return	array(
		'title' => $d->project->getName(),
		'controls' => $select_project,
		'body' => 	$editable_project_info
					.$hidden_forms
					.$hours_table
					.$estimate_table
		);

}
?>