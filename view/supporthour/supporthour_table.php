<?php
function supporthourTable( $hours, $o = array()){
    $r =& getRenderer();
    if( !$hours ) return false;
    $table = array();
    $table['headers'] = array(	'ID',
    							'Description',
                                'Date Completed',
    							'Staff',
    							'Hours',
    							'Discount',
    							'Billable Hours'
    							);
    $table['rows'] =  array();
    $total_hours = 0;
    $billable_hours = 0;
    foreach($hours as $h){
      $total_hours += $h->getHours();
      $billable_hours += $h->getBillableHours();
      $table['rows'][] = array(	$h->id,
      							$r->link( 'SupportHour', array('action'=>'show','id'=>$h->id),$h->getName()),
      							$h->getData('date'),
      							$h->getStaffName(),
      							$h->getHours(),
      							$h->getDiscount(),
      							$h->getBillableHours()
      							);
    }
    if ( !isset($o['title'])) $o['title'] = 'Hours';
    $html = 
         '<div class="totals-data totals-hours"><h3 class="basic-table-header">Total Support Hours: ' . $total_hours . '</h3></div>'
        . '<div class="totals-data totals-hours"><h3 class="basic-table-header">Billable Support Hours: ' . $billable_hours . "</h3></div>"
        . $r->view( 'basicTable', $table,
          array('title'=>'Support Hours', $o)) ;
    return $html;
}
