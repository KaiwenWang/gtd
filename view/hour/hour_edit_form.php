<?php
function hourEditForm( $h, $o = array()){
    $r =& getRenderer();

	$e = new Estimate( $h->get('estimate_id'));
	$estimate_field = $r->field( $h, 'estimate_id', array( 'project_id' => $e->get('project_id')));
    
    $list_items = array(
		'ID'			=> $h->id,
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
    							array( 'title'=>'Edit Hour "'.$h->getName().'"', 'display'=>'inline')
    							).$r->submit();
    $o['redirect'] = $r->url('HourEdit',$h);
    return $r->form( 'post', 'Hour', $form_contents, $o);
}
?>
