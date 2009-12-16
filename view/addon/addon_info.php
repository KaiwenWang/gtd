<?php
function addonInfo( $addon, $options ) {
    $r =& getRenderer();
    $list_items = array(
    	'Company'				    => $r->link('Company',
												array('action'=>'show','id'=>$addon->get('company_id')),
												$addon->getCompanyName()
										),
    	'Domain Name'				=> $addon->getData('domain_name'),
    	'Tech'				        => $addon->getData('technology'),
    	'Support Hours'				=> $addon->getData('support_hours'),
    	'Hourly Rate'				=> $addon->getData('hourly_rate'),
    	'Monthly Rate'				=> $addon->getData('monthly_rate'),
    	'Pro Bono'				    => $addon->getData('pro_bono'),
    	'addon On File'			=> $addon->getData('addon_on_file'),
    	'Status'				    => $addon->getData('status'),
    	'Not Monthly'				=> $addon->getData('not_monthly'),
    	'Notes'				        => $addon->getData('notes'),
    	'Start Date'				=> $addon->getData('start_date'),
    	'End Date'				    => $addon->getData('end_date'),
    	'addon Url'				=> $addon->getData('addon_url'),
        'Total Hours'		        => $addon->getTotalHours( ),
        'Billable Hours'		    => $addon->getBillableHours( )
    );
    $addon_info = $r->view( 'basicList', $list_items)
					.$r->link( 'AddOn', 
									array( 'action'=>'edit', 'id'=>$addon->id), 
									'Edit Addon', 
									array( 'id'=>'edit-addon-btn', 'class'=>'standard-btn')
							  	);

    return $addon_info;
}
