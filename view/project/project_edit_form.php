<?php
function projectEditForm( $p, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'Project', 'action'=>'update'));
    $fs = $form->getFieldSetFor($p);

	$list_items = array(
			'Name' =>			$fs->name,
			'Status' =>			$fs->status,
			'Launch Date' =>	$fs->launch_date,
			'Company' =>		$fs->company_id,
			'Project Manager'=> $fs->staff_id,
			'Designer'=>		$fs->desinger,
			'Domain'=> $fs->domain_notes,
			'Initial Estimated Cost'=> $fs->cost,
			'Hour Cap'=>		$fs->hour_cap,
			'Hourly Rate'=>		$fs->hourly_rate,
			'Billing Status'=> $fs->billing_status,
            'Server' =>         $fs->server
			);
			
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Edit Project')
    						  );

    return $form->html;
}
