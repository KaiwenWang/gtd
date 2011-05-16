<?php
function projectNewForm( $project, $o = array()){
    $r = getRenderer();

    $form = new Form( array('controller'=>'Project','action'=>'create'));

    $f = $form->getFieldSetFor($project);
    
    $list_items = array(
  		'Name' => $f->name,
  		'Company' => $f->company_id,
  		'Internal Project' => $f->internal,
  		'Status'=> $f->status,
  		'Project_Manager'=>$f->staff_id,
  		'Launch Deadline' =>$f->launch_date,
  		'Discovery Deadline' => $f->discovery_date,
  		'Notes'=> $f->other_notes,
  		'Domain'=> $f->domain_notes,
  		'Initial Estimated Cost'=> $f->cost,
  		'Hour Cap'=> $f->hour_cap,
  		'Hourly Rate'=> $f->hourly_rate,
  		'Billing Status'=> $f->billing_status,
      'Server' => $f->server
  	);		

    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Add Project', 'display'=>'inline')
    						  );

    return array(
		'title' => 'New Project',
		'body' => $form->html
	);
}
