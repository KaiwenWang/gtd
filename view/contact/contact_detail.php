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
	$html .= '<div>Name: '. $contact->get('first_name').' '.$contact->get('last_name'). '</div> ';
	$html .= '<div>Email: <a href="'.$contact->get('email').'"/>'.$contact->get('email').'</a></div>';
	$html .= '<div>Phone: '.$contact->get('phone').'</div>';

	if ($contact->get('is_billing_contact') == 1) {
		$html .= '&bull; Billing Contact <br />';
	}
	if ($contact->get('is_primary_contact') == 1) {
		$html .= '&bull; Primary Contact <br />';
	}
	if ($contact->get('is_technical_contact') == 1) {
		$html .= '&bull;  Technical Contact <br />';
	}
	return $html;
}
?>
