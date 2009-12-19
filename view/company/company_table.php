<?php
function companyTable( $modelObjects, $o = array()){
    $r =& getRenderer();
    $table = array();

    $table['headers'] = array('Client','Status','Balance');

    $table['rows'] =  array();

    foreach($modelObjects as $m){
      $link = $r->link('Company',array('action'=>'show','id'=>$m->id),$m->getName());
      $table['rows'][] = array( $link, $m->getData('status'), $m->getData('balence') );
    }

    return $r->view( 'basicTable', $table, array('title'=>'Search Clients'));
  
}
?>
