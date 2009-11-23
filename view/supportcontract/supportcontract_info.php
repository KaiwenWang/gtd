<?php
function supportcontractInfo( $contract, $options ) {
    $r =& getRenderer();
    $list_items = array(
    	'Company'				    => $contract->getCompanyName(),
    	'Domain Name'				=> $contract->getData('domain_name'),
    	'Tech'				        => $contract->getData('technology'),
    	'Support Hours'				=> $contract->getData('support_hours'),
    	'Hourly Rate'				=> $contract->getData('hourly_rate'),
    	'Monthly Rate'				=> $contract->getData('monthly_rate'),
    	'Pro Bono'				    => $contract->getData('pro_bono'),
    	'Contract On File'			=> $contract->getData('contract_on_file'),
    	'Status'				    => $contract->getData('status'),
    	'Not Monthly'				=> $contract->getData('not_monthly'),
    	'Notes'				        => $contract->getData('notes'),
    	'Start Date'				=> $contract->getData('start_date'),
    	'End Date'				    => $contract->getData('end_date'),
    	'Contract Url'				=> $contract->getData('contract_url'),
        'Total Hours'		        => $contract->getTotalHours( ),
        'Billable Hours'		    => $contract->getBillableHours( )
    );
    $contract_info = $r->view( 'basicList', $list_items);
    
    return $contract_info;
}