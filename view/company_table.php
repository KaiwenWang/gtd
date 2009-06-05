<?php

function companyTable( $modelObjects, $o = array()){
    $out = array();
    $out['headers'] = array('Company','Status','Balance');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $out['rows'][] = array($m->getName(),$m->getData('status'),$m->getData('balence') );
    }

    $r = getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
  
}
?>
