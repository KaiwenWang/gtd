<?php

function staffTable( $modelObjects, $o = array()){
    $out = array();
    $out['headers'] = array('Name','Team','Email');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $out['rows'][] = array($m->getName(),$m->getData('team'),$m->getData('email') );
    }

    $r =& getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
  
}
?>
