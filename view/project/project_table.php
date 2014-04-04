<?php

function projectTable($projects, $o = array()) {
  if(!$projects) return;
  $r = getRenderer();

  $search_form = '';
  if(!empty($o['search_project']) && is_a($o['search_project'], 'Project')) {
    $form = new Form(array(
      'controller' => 'Project',
      'action' => 'index',
      'method' => 'get',
      'auto_submit' => array('org_type', 'country', 'status'),
    ));
    $f = $form->getFieldSetFor($o['search_project']);
    $form_content .= $f->field('status', array('title' => 'Status'));
    $form->content = $form_content; 
    $search_form = $form->html;
  }
  
  $table = array();
  $table['headers'] = array(
    'ID',
    'Project Name',
    'Status',
    'Project Manager',
    'Launch Date',
    'Billing Status',
    'Total Cost Est',
    'Hours'
  );
  $table['rows'] =  array();
  foreach($projects as $p) {
    $table['rows'][] = array(
    $p->id,
    $r->link('Project', array('action' => 'show', 'id' => $p->id), $p->getName()),
    $p->get('status'),
    $p->getStaffName(),
    $p->get('launch_date'),
    $p->get('billing_status'),
    $p->get('cost'),
    $p->getBillableHours()
   );
  }
  $html = $r->view('basicTable', $table, array('title' => 'Projects', 'search' => $search_form, 'pager' => true));
  return $html;
}

?>
