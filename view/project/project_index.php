<?php

function projectIndex($d) {
  $r = getRenderer();  

  $new_project_form = $r->view('jsHideable', array('Create New Project' => $r->view('projectNewForm', $d->new_project)));
  $project_table = $r->view('projectTable', $d->projects, array('id' => 'project', 'search_project' => $d->search_project));

  return array(
    'title' => 'All Projects',
    'controls' => '',
    'body' => $new_project_form
      . $project_table
  );
}

?>
