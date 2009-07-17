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
    foreach($hours as $e){
      $table['rows'][] = array(	$e->id,
      							$e->getName(),
      							$e->getData('date'),
      							$e->getStaffName(),
      							$e->getHours(),
      							$e->getDiscount(),
      							$e->getBillableHours()
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Hours'));
    return $html;
}
?>
