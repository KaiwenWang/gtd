<?php
function projectNewForm( $p, $o = array()){
    $r =& getRenderer();
    $list_items = array(
		'Name' => $r->field( $p, 'name'),
		'Status'=> $r->field( $p, 'status'),
		'Launch Deadline' =>$r->field( $p, 'launch_date'),
		'Discovery Deadline' => $r->field( $p, 'discovery_date'),
		'Notes'=> $r->field( $p, 'other_notes'),
		'Domain'=> $r->field( $p, 'domain_notes'),
		'Initial Estimated Cost'=> $r->field( $p, 'cost'),
		'Hour Cap'=> $r->field( $p, 'hour_cap'),
		'Hourly Rate'=> $r->field( $p, 'hourly_rate'),
		'Billing Status'=> $r->field( $p, 'billing_status')
	);	
    
    $form_contents = $r->view( 'basicList', 
    							$list_items, 
    							array( 'title'=>'Add Project', 'display'=>'inline')
    						  );
    						  
	   $form_contents .= $r->hidden('company_id',$p->get('company_id'));
		  
    $o['method'] = 'post';
    
    return $r->form( 'create', 'Project', $form_contents.$r->submit(), $o);
}
?>