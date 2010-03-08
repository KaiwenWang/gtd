<?php
function companyTable( $companies, $o = array()){
	if(!$companies) return;

    $r =& getRenderer();

    $table = array();

    $table['headers'] = array('Client','Status','Balance');

    $table['rows'] =  array();

    foreach($companies as $c){
      $link = $r->link('Company',array('action'=>'show','id'=>$c->id),$c->getName());
      $table['rows'][] = array( $link, $c->getData('status'), $c->getData('balence') );
    }

    return $r->view( 'basicTable', $table, array('title'=>'Search Clients'));
  
}
?>
