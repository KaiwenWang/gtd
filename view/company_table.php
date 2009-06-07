<?php

function companyTable( $modelObjects, $o = array()){
    $out = array();
    $out['headers'] = array('Company','Status','Balance');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $link = '<a href="index.php?controller=CompanyDetail&company_id='.$m->id.'">'.$m->getName().'</a>';
      $out['rows'][] = array( $link, $m->getData('status'), $m->getData('balence') );
    }

    $r =& getRenderer();
    $html = $r->view('basicTable',$out);
    return $html;
  
}
?>
