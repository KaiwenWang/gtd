<?php
function projectIndex($d){
	$r =& getRenderer();
	
	$d->staff 	? $page_title = $d->staff->getName().'\'s Projects'
				: $page_title = 'All Projects';
	
	$select_by_staff = $r->classSelect( 'Staff',
										array(	'name'=>'id',
												'selected_value'=>$d->staff_selected_value,
												'select_none'=>'All Staff Members'),
										array('sort'=>'first_name'));
	$select_by_staff .= $r->submit();
	$select_by_staff = $r->form( 'show', 'Staff', $select_by_staff);
	
	$controls = $r->view('basicList', array('Projects by Staff'=>$select_by_staff));

	$new_project_form = $r->view('jsHideable',
  					array(
  						'Create New Project' => $r->view( 'projectNewForm', $d->new_project)
  					)
  				);

    $project_table = $r->view('projectTable', $d->projects, array('id'=>'project'));


        return	array(
               		'title'=>$page_title,
               		'controls'=>$controls,
               		'body'=>	$new_project_form
               					.$project_table
               		);
}
?>