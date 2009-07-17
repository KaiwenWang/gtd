<?php

function supportContractTable( $modelObjects, $o = array()){
    $out = array();
    $out['headers'] = array('Contract Name','Contract Status','Pro Bono','$ Monthly','$ Hourly','Hours Per Month','Contrct on File');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $link = '<a href="index.php?controller=SupportContractDetail&id='.$m->id.'">'.$m->getName().'</a>';
      $out['rows'][] = array($link,$m->getData('status'),$m->getData('pro_bono'),$m->getData('monthly_rate'),$m->getData('hourly_rate'),$m->getData('support_hours'),$m->getData('contract_on_file') );
    }

    $r =& getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
  
}
?>
