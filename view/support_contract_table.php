<?php

function supportContractTable( $modelObjects, $o = array()){
    $r =& getRenderer();
    $out = array();
    $out['headers'] = array('Contract Name',
    						'Contract Status',
    						'Pro Bono',
    						'$ Monthly',
    						'$ Hourly',
    						'Hours Per Month',
    						'Contrct on File');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $out['rows'][] = array(	$r->link( 'SupportContractDetail', array('id'=>$m->id),$m->getName()),
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
