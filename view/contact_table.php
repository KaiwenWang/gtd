<?php

/**
  	contactTable
    
    View that displays a list of all Contacts
   
   	$get options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package controller

*/

function contactTable( $contacts, $o = array()){
	if( !$contacts) return '';
    $r =& getRenderer();
    $table = array();
    $table['headers'] = array('Contact',
    						'Company',
    						'Email');
    $table['rows'] =  array();
    foreach($contacts as $contact){
      $company = $contact->getCompany();
      $table['rows'][] = array( $r->link( 'ContactDetail', array('contact_id'=>$contact->id), $contact->getName()),
      						  $r->link( 'CompanyDetail', array('company_id'=>$company->id), $company->getName()),
      						  '<a href="'.$contact->getData('email').'"/>'.$contact->getData('email').'</a>'
      						  );
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Contacts'));
    return $html;
  
}
?>
