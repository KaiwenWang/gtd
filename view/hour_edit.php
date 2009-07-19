<?php

function hourEdit( $h, $o = array()){
    $r =& getRenderer();
    $list_items = array(
        'Date Completed'=> $r->field( $h, 'date'),
    	'Estimate' 		=> $r->field( $h, 'estimate_id'),
       	'Description' 	=> $r->field( $h, 'description'),
        'Staff' 		=> $r->field( $h, 'staff_id'),
        'Hours' 		=> $r->field( $h, 'hours'),        
        'Discount' 		=> $r->field( $h, 'discount'),
		'Basecamp ID' 	=> $r->field( $h, 'basecamp_id')
    );
    $form_contents = $r->view( 'basicList', $list_items) . $r->submit();
    
    return $r->form( 'post', 'HourEdit', $form_contents, array( 'redirect' => $r->url('HourEdit',$h)));
}
?>
