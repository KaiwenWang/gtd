<?php

/**
  	contactDetail
    
    View that displays the detail page for Contacts
   
   $get options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package view

*/

function contactDetail($contact, $o){
	$html = '';
	$html .= '<div>Name: '. $contact->getData('first_name').'</div> ';
	$html .= '<div>Email: <a href="'.$contact->getData('email').'"/>'.$contact->getData('email').'</a></div>';

	if ($contact->getData('is_billing_contact') == 1) {
		$html .= '&bull; Billing Contact <br />';
	}
	if ($contact->getData('is_primary_contact') == 1) {
		$html .= '&bull; Primary Contact <br />';
	}
	if ($contact->getData('is_technical_contact') == 1) {
		$html .= '&bull;  Technical Contact <br />';
	}
	return $html;
}
?>