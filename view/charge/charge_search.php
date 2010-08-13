<?php

function chargeSearch($charges, $o) {
	$r = getRenderer();
	
	$type = isset($o['type']) ? $o['type'] : '';
	$company_id = isset($o['company_id']) ? $o['company_id'] : '';
	$start_date = isset($o['date_range']['start_date']) ? $o['date_range']['start_date'] : '';
	$end_date = isset($o['date_range']['end_date']) ? $o['date_range']['end_date'] : '';

	$form = new Form(array(
						'controller'=>'Charge',
						'action'=>'search',
						'method'=>'get',
						'auto_submit'=> array('company_id','type','start_date','end_date'),
						'ajax_target_id'=>'charges-table'
					));	

	$charge = new Charge();
	$charge->set(array('type'=>$type));
	$fs = $form->getFieldSetFor( $charge );

	$form->content .= $fs->field('type',array('title'=>'Type','name'=>'type'));
	$form->content .= $r->classSelect('Company',
										array(
										'title'=>'Client',
										'name'=>'company_id',
										'id'=>'company_id',
										'selected_value' => $company_id)
									);
	
	$form->content .= '<div class="search-input">
        	<label for="charge_search_start">Start Date</label>
			'.$r->input( 'date', array(	'name'=>'date_range[start_date]',
										'value'=>$start_date,
										'id'=>'charge_search_start'
										)).'
        </div>
        <div class="search-input">
          	<label for="charge_search_end">End Date</label>
			'.$r->input( 'date', array(	'name'=>'date_range[end_date]',
										'value'=>$end_date,
										'id'=>'charge_search_end'
										)).'
		</div>
			';
 

	$o['search'] = $form->html;

	return	$r->view('chargeTable', $charges, $o);

}


