<?php

function companyTable( $modelObjects, $o = array()){
    $r =& getRenderer();
    $table = array();
    $table['headers'] = array('Company','Status','Balance');
    $table['rows'] =  array();
    foreach($modelObjects as $m){
      $link = $r->link('CompanyDetail',array('id'=>$m->id),$m->getName());
      $table['rows'][] = array( $link, $m->getData('status'), $m->getData('balence') );
    }


    $html = $r->view( 'basicTable', $table, array('title'=>'Companies'));
    return $html;
  
}
?>
