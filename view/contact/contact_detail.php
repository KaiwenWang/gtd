<?php
function contactDetail($contact, $o){
	$r = getRenderer();

	if ($contact->get('is_technical_contact'))	$type = 'Technical Contact';
	if ($contact->get('is_billing_contact'))	$type = 'Billing Contact';
	if ($contact->get('is_primary_contact'))	$type = 'Primary Contact';

	
	$contact->get('fax') ? $fax = '<div>'.$contact->get('fax').'</div>'
						 : $fax = '';

	return '
			<div class="contact-detail">	
				<h4>'.$r->link('Contact',array('action'=>'show','id'=>$contact->id),$type).'</h4>	
				<div>Name: '. $contact->get('first_name').' '.$contact->get('last_name'). '</div> 
				<div>Email: <a href="'.$contact->get('email').'"/>'.$contact->get('email').'</a></div>
				<div>Phone: '.$contact->get('phone').'</div>
				'.$fax.'
			</div>
			';
}
