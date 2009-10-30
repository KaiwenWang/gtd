<?php
function projectNewForm( $project, $o = array()){
    $r = getRenderer();

    $form = new Form( array('controller'=>'Project','action'=>'create'));

    $f = $form->getFieldSetFor($project);
    $list_items = array(
		'Name' => $f->name,
		'Company' => $f->company_id,
		'Status'=> $f->status,
		'Launch Deadline' =>$f->launch_date,
		'Discovery Deadline' => $f->discovery_date,
		'Notes'=> $f->other_notes,
		'Domain'=> $f->domain_notes,
		'Initial Estimated Cost'=> $f->cost,
		'Hour Cap'=> $f->hour_cap,
		'Hourly Rate'=> $f->hourly_rate,
		'Billing Status'=> $f->billing_status
	);	
    
    $form->content = $r->view( 'basicList', 
    							$list_items, 
    							array( 'title'=>'Add Project', 'display'=>'inline')
    						  );

    return $form->html;
}
?>