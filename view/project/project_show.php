<?php

function projectShow($d) {
  $r = getRenderer();

  $editable_project_info= $r->view('jsSwappable',
    'Project Info',
    array(
      $r->view('projectInfo', $d->project),
      $r->view('projectEditForm' , $d->project)
    )
  );

  $hidden_forms = $r->view('jsMultipleButtons',
    array(
      'Create New Estimate' => $r->view('estimateNewForm', 
        $d->new_estimate
      ),        
      'Log Hours' => $r->view('hourNewForm', 
        $d->new_hour, 
        array('project_id' => $d->project->id)
      )
    ),
    array('open_by_default' => array('Log Hours'))
  );

  $estimate_table = $r->view('estimateTable', $d->project->getEstimates());
  $hour_table = $r->view('hourTable', $d->project->getHours());
  
  return array(
    'title' => $d->project->getName(),
    'body' => $editable_project_info
      . $hidden_forms
      . $estimate_table
      . $hour_table
  );
}

?>
