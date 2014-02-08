<?php

function estimateTable($estimates, $o = array()) {
  if(!$estimates) return;
  $r = getRenderer();
  $table = array();
  $table['headers'] = array(
    'ID',
    'Description',
    'Low',
    'High',
    'Total Hours',
    'Billable Hours',
    'Notes',
    'Completed'
  );
  $table['rows'] = array();
  foreach($estimates as $e) {
    $table['rows'][] = array(
      $e->id,
      $r->link('Estimate', array('action' => 'show', 'id' => $e->id), $e->getName()),
      $e->getLowEstimate(),
      $e->getHighEstimate(),
      $e->getTotalHours(),
      $e->getBillableHours(),
      $e->getData('notes'),
      $e->getData('completed') ? 'Yes' : 'No'
    );
  }
  $html = $r->view('basicTable', $table, array('title' => 'Estimates', 'pager' => true));
  return $html;
}

?>
