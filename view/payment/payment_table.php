<?php

function paymentTable( $modelObjects, $o = array()){
	if ( !$modelObjects) return;
    $out = array();
    $out['headers'] = array('Company','Date','Amount');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $out['rows'][] = array($m->getName(),$m->getData('date'),$m->getAmount() );
    }
    $r =& getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
}
?>
