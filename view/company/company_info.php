<?php
function companyInfo( $c, $o){

	$address = $c->get('street').'<br>';
	if ($c->get('street_2')) $address.= $c->get('street2').'<br>';
	if ($c->get('city')) 	 $address.= $c->get('city').',';
	$address.= $c->get('state').'<br>';
	$address.= $c->get('zip');

	$c->get('notes') ? $notes = ' 
								<div class="notes-box">
									<div class="notes-content">	
										'.nl2br($c->get('notes')).'
									</div>
								</div>'
					 : $notes = '';

	return '
			<div class="company-info-header">
				<div class="status">
					'.$c->get('status').'
				</div>
				<h2>
					'.$c->get('name').'
				</h2>
			</div>
			'.$notes.'	
			<div class="address">
				'.$address.'<br>
				'.$c->get('phone').'
			</div>
			<div class="clear-both"></div>
		';
}
