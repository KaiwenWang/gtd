<?php

/**
  	contactTable
    
    View that displays a list of all Contacts
   
   	$get options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package controller

*/

function contactTable( $modelObjects, $o = array()){
    $r = getRenderer();
    $out = array();
    $out['headers'] = array('Contact','Company','Email');
    $out['rows'] =  array();
    foreach($modelObjects as $m){
      $company = $m->getCompany();
      $out['rows'][] = array( $m->getName(),$company->getName(),$m->getData('email') );
    }
    $html = $r->view('basicTable',$out);
    return $html;
  
}
?>
