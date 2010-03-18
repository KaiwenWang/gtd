<?php
function supportcontractCorrectMistakeForm( $contract, $o = array() ){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'SupportContract', 'action'=>'update'));
    $fs = $form->getFieldSetFor($contract);

    $list_items = array(
    	'Company'				    => $fs->company_id,
		'Previous Contract'			=> $fs->field( 'previous_contract_id', array('title'=>'None')),
		'Replacement Contract'		=> $fs->field( 'replacement_contract_id', array('title'=>'None')),
    	'Domain Name'				=> $fs->domain_name,
    	'Tech'				        => $fs->technology,
    	'Support Hours'				=> $fs->support_hours,
    	'Hourly Rate'				=> $fs->hourly_rate,
    	'Monthly Rate'				=> $fs->monthly_rate,
    	'Pro Bono'				    => $fs->pro_bono,
    	'Contract On File'			=> $fs->contract_on_file,
    	'Status'				    => $fs->status,
    	'Not Monthly'				=> $fs->not_monthly,
    	'Notes'				        => $fs->notes,
    	'Start Date'				=> $fs->start_date,
    	'End Date'				    => $fs->end_date,
    	'Contract Url'				=> $fs->contract_url
    );

    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Edit Contract')
    						  );

    return $form->html;
}
