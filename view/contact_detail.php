<?php

/**
  	contactDetail
    
    View that displays the detail page for Contacts
   
   $get options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package view

*/

function contactDetail($data, $o){
	$html = '';
	$html .= '<h2>Viewing Details for '.$data->getName().'</h2>';
	$html .= '<div>Name: '. $data->getData('first_name').'</div> ';
	$html .= '<div>Email: '.$data->getData('email').'</div>';
	if ($data->getData('is_billing_contact') == 1) {
		$html .= '&bull; Billing Contact <br />';
	}
	if ($data->getData('is_primary_contact') == 1) {
		$html .= '&bull; Primary Contact <br />';
	}
	if ($data->getData('is_technical_contact') == 1) {
		$html .= '&bull;  Technical Contact <br />';
	}
	return $html;
}
?>