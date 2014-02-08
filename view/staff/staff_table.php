<?php

function staffTable($staffers, $o = array()) {
  $r = getRenderer();
  $staff_table = array(
    'current' => array(
      'headers' => array('Name', 'Team', 'Email', 'Edit'),
      'rows' => array()
    ), 
    'former' => array(
      'headers' => array('Name', 'Team', 'Email', 'Edit'),
      'rows' => array()
    )
   );

  foreach($staffers as $s) {
    $rows_var = 'current';
    if($s->getData('active') == 0) {
      $rows_var = 'former';
    }

    $staff_table[$rows_var]['rows'][] = array(
      $r->link('Staff', array('action' => 'show', 'id' => $s->id), $s->getName()),
      $s->getData('team'),
      '<a href="mailto:'.$s->getData('email').'">'.$s->getData('email').'</a>',
      UI::button(array('controller' => 'Staff', 'action' => 'edit', 'id' => $s->getData('id')))
    );
  }
  
  $html = $r->view('basicTable', $staff_table['current'], array('title' => 'Staff', 'pager' => true), $o);
  $html .= $r->view('basicTable', $staff_table['former'], array('title' => 'Former Staff', 'pager' => true), $o);
  return $html;
}

?>
