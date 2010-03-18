<?php
function companyEditForm( $c, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'Company', 'action'=>'update'));
    $fs = $form->getFieldSetFor($c);

    $list_items = array(
		'Name'		=> $fs->name,
		'Status'	=> $fs->status,
		'Street'	=> $fs->street,
		'Street 2'	=> $fs->street_2,
		'City'		=> $fs->city,
		'State'		=> $fs->state,
		'Zip'		=> $fs->zip,
		'Bay Area'	=> $fs->bay_area,
		'Notes'		=> $fs->notes
	);	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Edit Client')
    						  );
    
    return $form->html;
}
