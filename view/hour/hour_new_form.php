<?php
function hourNewForm( $h, $o = array()){
    $r = getRenderer();
    
    $form = new Form( array( 'controller'=>'Hour', 'action'=>'create'));
    $fs = $form->getFieldSetFor( $h );

	if( isset($o['project_id']) ){
		$estimate_field = $fs->field( 'estimate_id', 
									   array('project_id'=>$o['project_id'])
									  );
	} else {
		$estimate_field = $fs->estimate_id;
	}

    $list_items = array(
					'Estimate' 		=> $estimate_field,
					'Description' 	=> $fs->description,
					'Staff' 		=> $fs->staff_id,
      		'Pair' 		=> $fs->field('pair_id',array('select_none'=>'Not Paired', 'active' => 'true')),
					'Hours' 		=> $fs->hours,        
					'Discount' 		=> $fs->discount,
					'Date Completed'=> $fs->date
					);	

	isset($o['title']) 	? $title = 'Add Hour: '.$o['title']
						: $title = 'Add Hour';
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=> $title, 'display'=>'inline')
    						  	);
    
    return $form->html;
}
