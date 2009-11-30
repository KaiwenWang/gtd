<?php
function projectIndex($d){
	$r = getRenderer();	

	$new_project_form = $r->view('jsHideable', array(
  						'Create New Project' => $r->view( 'projectNewForm', 
  														  $d->new_project)
  							)
  						);

    $project_table = $r->view('projectTable', $d->projects, array('id'=>'project'));


    return	array(
           		'title'=> 'All Projects',
           		'body'=>	$new_project_form
           					.$project_table
           		);
}
