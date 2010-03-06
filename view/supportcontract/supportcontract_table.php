<?php
function supportcontractTable( $contracts, $o = array()){
    $r =& getRenderer();

	if(!$contracts) return $r->view('basicMessage','There are no Support Contracts at this time.');

    $out = array();
    $out['headers'] = array('Contract Name',
    						'Contract Status',
    						'Pro Bono',
    						'$ Monthly',
    						'$ Hourly',
    						'Hours Per Month',
    						'Contrct on File');
    $out['rows'] =  array();
    foreach($contracts as $m){
      $out['rows'][] = array(	$r->link( 'SupportContract', array('action'=>'show','id'=>$m->id),$m->getName()),
      							$m->getData('status'),
      							$m->getData('pro_bono'),
      							$m->getData('monthly_rate'),
      							$m->getData('hourly_rate'),
      							$m->getData('support_hours'),
      							$m->getData('contract_on_file') );
    }

    $html = $r->view('basicTable',$out, array('title'=>'Support Contracts'));
    return $html;
}
?>
