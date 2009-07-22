<?php
function hourEditForm( $h, $o = array()){
    $r =& getRenderer();
	if( $h->getData( 'estimate_id')){
		$e = new Estimate( $h->getData( 'estimate_id'));
		$estimate_field = $r->field( $h, 'estimate_id', array( 'project_id' => $e->getData( 'project_id')));
	}
    
    $list_items = array(
		'ID'			=> $h->id,
        'Date Completed'=> $r->field( $h, 'date'),
    	'Estimate' 		=> $estimate_field,
       	'Description' 	=> $r->field( $h, 'description'),
        'Staff' 		=> $r->field( $h, 'staff_id'),
        'Hours' 		=> $r->field( $h, 'hours'),        
        'Discount' 		=> $r->field( $h, 'discount'),
		'Basecamp ID' 	=> $r->field( $h, 'basecamp_id')
    );
    $form_contents = $r->view( 'basicList', $list_items, array('title'=>'Edit Hour "'.$h->getName().'"')) . $r->submit();
    
    return $r->form( 'post', 'HourEdit', $form_contents, array( 'redirect' => $r->url('HourEdit',$h)));
}
?>
