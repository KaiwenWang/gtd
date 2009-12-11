<?php
function staffShow($d){
	$r = getRenderer();

	$hidden_forms = $r->view( 'jsHideable' ,array(
														
						'Create New Project'	=> $r->view(
													'projectNewForm', 
													$d->new_project
												),
						'Log Support Hour'	=> $r->view(
													'supporthourNewForm', 
													$d->new_support_hour
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
