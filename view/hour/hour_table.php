<?php
function hourTable( $hours, $o = array()){
    $r = new Render;

    $table['headers'] = array('id', 'Action','Logged', 'Staff','Hours','Billable');

    $table['rows'] =  array();
    
    $total_hours = 0;
    $billable_hours = 0;
    foreach($hours as $h){
      $total_hours += $h->getHours();
      $billable_hours += $h->getBillableHours();

      $table['rows'][] = array(	$h->id,
      $r->link( 'Hour', array('action'=>'show','id'=>$h->id),$h->getName()),
      $h->getData('date'),
      $h->getStaffName(),
      $h->getHours(),
      $h->getBillableHours()
      );
    
  /*  foreach($modelObjects as $m){
      $link = $r->link('Hour',array('action'=>'show','id'=>$m->id),$m->getName());
      $table['rows'][] = array( $link, $m->getData('taff'), $m->getData('dwbalence') );
   */
    }
  #$table['rows'][] = array(	'TOTAL', '', '', '', $total_hours, $billable_hours );

    return $r->view( 'basicTable', $table, 
          array('title'=>'Hours', 'search' => $r->view('hourSearch'))) 
        . '<div class="totals-data"><h3 class="basic-table-header">Total Hours: ' . $total_hours . '</h3></div>'
        . '<div class="totals-data"><h3 class="basic-table-header">Billable Hours: ' . $billable_hours . "</h3></div><p>&nbsp;</p>";
  
}
