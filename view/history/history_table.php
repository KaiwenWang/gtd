<?php

function historyTable($items, $o = array()) {
  $r = getRenderer();

  if(!$items) return $r->view('basicMessage', 'No History Available');

  $table = array();
  $table['headers'] = array('Date', 'Type', 'Name', 'Description', 'Amount');
  $table['rows'] =  array();

  foreach($items as $i) {
    $table['rows'][] = array(
      $i->getHistoryDate(),
      $i->getHistoryType(),
      $i->getHistoryName(),
      $i->getHistoryDescription(),
      $i->getHistoryAmount()
    );
  }

  return $r->view('basicTable', $table, array('title' => 'Client History', 'pager' => true));
}

?>
