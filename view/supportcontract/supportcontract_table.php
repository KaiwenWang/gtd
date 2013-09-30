<?php
function supportcontractTable( $contracts, $o = array()){
    $r =& getRenderer();

	if(!$contracts) return $r->view('basicMessage','There are no Support Contracts at this time.');

    $out = array();
    $out['headers'] = array('Contract Name',
    						'Status',
    						'Start Date',
    						'End Date',
    						'Pro Bono',
    						'$ Monthly',
    						'$ Hourly',
    						'Hours Per Month'
    						);
    $out['rows'] =  array();
    foreach($contracts as $m){
      $out['rows'][] = array(	$r->link( 'SupportContract', array('action'=>'show','id'=>$m->id),$m->getName()),
      							$m->getData('status'),
      							$m->getData('start_date'),
      							$m->getData('end_date'),
      							$m->getData('pro_bono'),
      							$m->getData('monthly_rate'),
      							$m->getData('hourly_rate'),
      							$m->getData('support_hours')
    							);
	}

    $html = $r->view('basicTable',$out, array('title'=>'Support Contracts', 'pager' => true));
    return $html;
}
?>
