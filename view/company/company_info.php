<?php
function companyInfo( $c, $o){
	if(get_class($c) != 'Company') bail('companyInfo requires a Company object');

	$r = getRenderer();

	$address = $c->get('street').'<br>';
	if ($c->get('street_2')) $address.= $c->get('street2').'<br>';
	if ($c->get('city')) 	 $address.= $c->get('city').',';
	$address.= $c->get('state').'<br>';
	$address.= $c->get('zip');

	$balance = $c->calculateBalance(array('end_date'=>Util::date_format_from_time()));

	$c->get('notes') ? $notes = ' 
								<div class="notes-box">
									<div class="notes-content">	
										'.nl2br($c->get('notes')).'
									</div>
								</div>'
					 : $notes = '';

	$contacts = '';
	if($primary = $c->getPrimaryContact()) $contacts.= $r->view('contactDetail',$primary);
	if($billing = $c->getBillingContact()) $contacts.= $r->view('contactDetail',$billing);
	if($technical = $c->getTechnicalContact()) $contacts.= $r->view('contactDetail',$technical);

	return '
			<div class="company-info-header">
				<div class="company-info">
				<h2>
					'.$c->getName().'
				</h2>
			<div class="company-balance">
				Current Balance: $ '.$balance.'
			</div>
			<div class="clear-both"></div>

					</div>
			<div class="clear-both"></div>
			<div class="address">
				'.$address.'<br>
				'.$c->getPhone().'
			</div>
			<div class="clear-both"></div>
			<div class="status">
					'.$c->getStatus().'
			</div>
			</div>
			<div class="company-contacts">
				'.$contacts.'
			</div>
			'.$notes.'	
			<div class="clear-both"></div>
		';
}
