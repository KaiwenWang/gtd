<?php
function supportcontractCancelForm( $contract, $o = array() ){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'SupportContract', 'action'=>'process_cancellation'));
    $fs = $form->getFieldSetFor($contract);

    $list_items = array(
    	'End Date'				    => $fs->end_date,
    	'Company'				    => $contract->get('company_id'),
    	'Domain Name'				=> $contract->get('domain_name'),
    	'Tech'				        => $contract->get('technology'),
    	'Support Hours'				=> $contract->get('support_hours'),
    	'Hourly Rate'				=> $contract->get('hourly_rate'),
    	'Monthly Rate'				=> $contract->get('monthly_rate'),
    	'Pro Bono'				    => $contract->get('pro_bono'),
    	'Contract On File'			=> $contract->get('contract_on_file'),
    	'Status'				    => $contract->get('status'),
    	'Not Monthly'				=> $contract->get('not_monthly'),
    	'Notes'				        => $contract->get('notes'),
    	'Start Date'				=> $contract->get('start_date'),
    	'Contract Url'				=> $contract->get('contract_url')
    );

    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Renew Contract')
    						  );

    return $form->html;
}
