<?php
function hourTable( $modelObjects, $o = array()){

    $table['headers'] = array('Company','Status','Balance');

    $table['rows'] =  array();
<<<<<<< Updated upstream
    foreach($hours as $h){
      $table['rows'][] = array(	$h->id,
      							$r->link( 'Hour', array('action'=>'show','id'=>$h->id),$h->getName()),
      							$h->getData('date'),
      							$h->getStaffName(),
      							$h->getHours(),
      							$h->getDiscount(),
      							$h->getBillableHours()
      							);
=======

    foreach($modelObjects as $m){
      $link = $r->link('Company',array('action'=>'show','id'=>$m->id),$m->getName());
      $table['rows'][] = array( $link, $m->getData('status'), $m->getData('balence') );
>>>>>>> Stashed changes
    }

    return $r->view( 'basicTable', $table, array('title'=>'Companies'));
  
}
