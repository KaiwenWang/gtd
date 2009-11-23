<?php
function hourEdit($d){
	$r = getRenderer( );

    $title = $d->project->getName();


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
														 $d->new_estimate
														),
														
						'Log Hours'	=> $r->view(
												'hourNewForm', 
												$d->new_hour, 
												array('project_id'=>$d->project->id)
											   )
					));

    $hour_edit_form = '<div id="hour-edit-container">
    				   '.$r->view( 'hourEditForm', 
    				   			  $d->hour, array('class'=>'clear-left')
    				   			  ).'
    				   	</div>';

    $hour_table = $r->view('hourTable', $d->estimate->getHours(), array('title'=>'Hours for '.$d->estimate->getName()));

    $estimate_table = $r->view('estimateTable', $d->project->getEstimates());

    return array(   'title' 	=> $title,
                    'controls'	=> '',
                    'body' 		=> 	$editable_project_info
                    				.$hidden_forms
                    				.$hour_edit_form
                    				.$hour_table
                    				.$estimate_table
    								);
}
