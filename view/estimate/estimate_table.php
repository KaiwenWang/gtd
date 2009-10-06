<?php

function estimateTable( $estimates, $o = array()){
	if( !$estimates) return;
    $r =& getRenderer();
    $table = array();
    $table['headers'] = array(	'ID',
    							'Description',
								'Due By',
    							'Low Estimate',
    							'High Estimate',
    							'Total Hours',
    							'Billable Hours',
    							'Notes',
    							'Completed'
    							);
    $table['rows'] =  array();
    foreach($estimates as $e){
      $table['rows'][] = array(	$e->id,
      							$r->link( 'Estimate', array('action'=>'edit','id'=>$e->id), $e->getName()),
      							$e->getData('due_date'),
      							$e->getLowEstimate(),
      							$e->getHighEstimate(),
      							$e->getTotalHours(),
      							$e->getBillableHours(),
      							$e->getData('notes'),
      							$e->getData('completed') ? 'Yes' : 'No'
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Estimates'));
    return $html;
}
?>
