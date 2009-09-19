<?php
function estimateNewForm( $e, $o = array()){
    $r =& getRenderer();
    $list_items = array(
		'Description' => $r->field( $e, 'description'),
		'High Estimate' => $r->field( $e, 'high_hours'),
		'Low Estimate' =>$r->field( $e, 'low_hours'),
		'Due Date' => $r->field( $e, 'due_date'),
		'Details' => $r->field( $e, 'notes')
	);	
    
    $form_contents = $r->view( 'basicList', 
    							$list_items, 
    							array( 'title'=>'New Estimate'.$e->getName().'"', 'display'=>'inline')
    						  );
    						  
	$form_contents .= $r->hidden('project_id',$e->project_id);
		  
    $o['method'] = 'post';
    
    return $r->form( 'update', 'Hour', $form_contents.$r->submit(), $o);
}
?>