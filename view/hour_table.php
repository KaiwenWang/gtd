<?php

function hourTable( $hours, $o = array()){
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
    foreach($hours as $h){
      $table['rows'][] = array(	$h->id,
      							$r->link( 'HourEdit', $h),
      							$h->getData('date'),
      							$h->getStaffName(),
      							$h->getHours(),
      							$h->getDiscount(),
      							$h->getBillableHours()
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Hours'));
    return $html;
}
?>
