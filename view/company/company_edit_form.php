<?php
function companyEditForm( $c, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'Company', 'action'=>'update'));
    $fs = $form->getFieldSetFor($c);

    $list_items = array(
		'Name'		=> $fs->name,
		'Status'	=> $fs->status,
		'Type'		=> $fs->org_type,
		'Bay Area'	=> $fs->bay_area,
		'Street'	=> $fs->street,
		'Street 2'	=> $fs->street_2,
		'City'		=> $fs->city,
		'State'		=> $fs->state,
		'Zip'		=> $fs->zip,
		'Country'	=> $fs->country,
		'Start Date' => $fs->date_started,
		'Close Date' => $fs->date_ended,
		'Notes'		=> $fs->notes
	);	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Edit Client')
    						  );
    
    return $form->html;
}
