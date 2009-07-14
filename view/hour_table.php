<?php

function hourTable( $estimates, $o = array()){
    $r =& getRenderer();
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
    foreach($estimates as $e){
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
