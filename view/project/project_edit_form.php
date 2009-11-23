<?php
function projectEditForm( $p, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'Project', 'action'=>'update'));
    $fs = $form->getFieldSetFor($p);

	$list_items = array(
			'Status' =>			$fs->status,
			'Launch Date' =>	$fs->launch_date,
			'Name' =>			$fs->name,
			'Company' =>		$fs->company_id,
			'Project Manager'=> $fs->staff_id,
			'Designer'=>		$fs->desinger,
			'Hour Cap'=>		$fs->hour_cap,
			'Hourly Rate'=>		$fs->hourly_rate
			);
			
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Edit Project')
    						  );

    return $form->html;
}
