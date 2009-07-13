<?php

function companyTable( $modelObjects, $o = array()){
    $table = array();
    $table['headers'] = array('Company','Status','Balance');
    $table['rows'] =  array();
    foreach($modelObjects as $m){
      $link = '<a href="index.php?controller=CompanyDetail&company_id='.$m->id.'">'.$m->getName().'</a>';
      $table['rows'][] = array( $link, $m->getData('status'), $m->getData('balence') );
    }

    $r =& getRenderer();
    $html = $r->view( 'basicTable', $table, array('title'=>'Companies'));
    return $html;
  
}
?>
