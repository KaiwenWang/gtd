<?php

function projectTable( $projects, $o = array()){
  if( !$projects) return;
  $r =& getRenderer();
  $table = array();
  $table['headers'] = array(	'ID',
    'Project Name',
    'Status',
    'Project Manager',
    'Launch Date',
    'Billing Status',
    'Total Cost Est',
    'Hours'
  );
  $table['rows'] =  array();
  foreach($projects as $p){
    $table['rows'][] = array(	$p->id,
      $r->link( 'Project', array('action'=>'show','id'=>$p->id), $p->getName()),
      $p->get('status'),
      $p->getStaffName(),
      $p->get('launch_date'),
      $p->get('billing_status'),
      $p->get('cost'),
      $p->getBillableHours()
    );
  }
  $html = $r->view( 'basicTable', $table, array('title'=>'Projects'));
  return $html;
}
?>
