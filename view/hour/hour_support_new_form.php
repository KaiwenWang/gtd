<?php
function hourSupportNewForm( $h, $o = array()){
    $r = getRenderer();
    
    $form = new Form( array( 'controller'=>'Hour', 'action'=>'create'));
    $fs = $form->getFieldSetFor( $h );

    $list_items = array(
    	'Support Contract' => $fs->support_contract_id,
       	'Description' 	=> $fs->description,
        'Date Completed'=> $fs->date,
        'Staff' 		=> $fs->staff_id,
        'Hours' 		=> $fs->hours,        
        'Discount' 		=> $fs->discount,
		'Basecamp ID' 	=> $fs->basecamp_id
    );	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Add Hour', 'display'=>'inline')
    						  );
		  
    
    return $form->html;
}
