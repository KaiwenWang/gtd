<?php

function estimateInfo($estimate, $o = array()) {
  $r = getRenderer();
  $project = new Project($estimate->get('project_id'));
  $project_link = $r->link('Project',
    array('action' => 'show', 'id' => $project->id),
    $project->get('name')
  );

  $list_items = array(
    'Estimate'     => $estimate->getName(),
    'Project'     => $project_link,
    'Due Date'     => $estimate->getData('due_date'),
    'High Estimate'   => $estimate->getHighEstimate(),    
    'Low Estimate'   => $estimate->getLowEstimate(),
    'Total Hours'   => $estimate->getTotalHours(),
    'Billable Hours'   => $estimate->getBillableHours(),
    'Completed'     => $estimate->getData('completed') ? 'yes' : 'no',
    'Notes'     => $estimate->getData('notes')
   );

  return $r->view('basicList', $list_items);  
}

?>
