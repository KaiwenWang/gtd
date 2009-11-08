<?php
function staffShow($d){
	$r = getRenderer();

	$hidden_forms = $r->view('jsHideable',array(
														
						'Create New Project'	=> $r->view(
													'projectNewForm', 
													$d->project
												)
					));

    $project_table = $r->view( 'projectTable', $d->staff->getProjects());

    return  array(	'title'=>$d->staff->getName(),
                    'controls'=>$r->view( 'jumpSelect', $d->staff),
                    'body'=> $hidden_forms
                    		.$project_table
                    );
}
?>