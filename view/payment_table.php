<?php

function paymentTable( $modelObjects, $o = array()){
    $out = array();
    $out['headers'] = array('Company','Date','Amount');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $out['rows'][] = array($m->getCompanyName(),$m->getData('date'),$m->getAmount() );
    }
    $r = getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
}
?>
