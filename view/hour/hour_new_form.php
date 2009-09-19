<?php
function hourNewForm( $h, $o = array()){
    $r =& getRenderer();
    
    $e = new Estimate( $h->get('estimate_id'));
	$estimate_field = $r->field( $h, 'estimate_id', array( 'project_id' => $o['project_id']));
    
    
    $list_items = array(
    	'Estimate' 		=> $estimate_field,
       	'Description' 	=> $r->field( $h, 'description'),
        'Date Completed'=> $r->field( $h, 'date'),
        'Staff' 		=> $r->field( $h, 'staff_id'),
        'Hours' 		=> $r->field( $h, 'hours'),        
        'Discount' 		=> $r->field( $h, 'discount'),
		'Basecamp ID' 	=> $r->field( $h, 'basecamp_id')
    );	
    
    $form_contents = $r->view( 'basicList', 
    							$list_items, 
    							array( 'title'=>'Add Hour', 'display'=>'inline')
    						  );
    						  
	$form_contents .= $r->hidden('project_id',$o['project_id']);
		  
    $o['method'] = 'post';
    
    return $r->form( 'create', 'Hour', $form_contents.$r->submit(), $o);
}
?>
