<?php

function estimateShow($d) {
  $r = getRenderer();

  $select_project = $r->view('jumpSelect', $d->project);

  $editable_project_info = $r->view('jsSwappable',
    'Estimate Info',
    array(
      $r->view('estimateInfo', $d->estimate),
      $r->view('estimateEditForm', $d->estimate)
    )
  );

  $hidden_forms = $r->view('jsMultipleButtons', array(
    'Create New Estimate' => $r->view(
      'estimateNewForm', 
      $d->new_estimate
    ),
    'Log Hours' => $r->view(
      'hourNewForm', 
      $d->new_hour, 
      array('project_id' => $d->project->id)
    )
  ));
        
  $estimate_table = $r->view('estimateTable', $d->estimates);
      
  $d->hours 
    ? $hours_table = $r->view('hourSearch',
        $d->hours,
        array( 
          'ajax_target_id' => 'hour-search-1',
          'estimate_id' => $d->estimate->id
        )
      )
    : $hours_table = '
      <div class="empty-table-message">
      No hours have been logged against this estimate in this period.
      </div>
      ';
  
  return array(
    'title' => $d->project->getName() . ': ' . $d->estimate->getName(),
    'controls' => $select_project,
    'body' => $editable_project_info
      . $hidden_forms
      . $estimate_table
      . $hours_table
  );
}

?>
