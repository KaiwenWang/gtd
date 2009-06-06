<?php

function projectTable( $modelObjects, $o = array()){
    $out = array();
    $out['headers'] = array('Project Name','Status','Project Manager','Launch Date','Billing Status','Total Cost Est');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $out['rows'][] = array($m->getName(),$m->getData('status'),$m->getStaffName(),$m->getData('launch_date'),$m->getData('billing_status'),$m->getData('cost'), );
    }

    $r =& getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
  
}
?>
