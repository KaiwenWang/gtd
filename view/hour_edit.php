<?php

function hourEdit( $h, $o = array()){
    $r =& getRenderer();
    $e = new Estimate( $h->getData( 'estimate_id'));
    if( $e->getData( 'project_id')) $estimate_criteria = array( 'project_id' => $e->getData( 'project_id'));
    if( $e->getData( 'support_contract_id')) $estimate_criteria = array( 'support_contract_id' => $e->getData( 'support_contract_id'));
    $list_items = array(
        'Date Completed' => $r->field( $h, 'date'),
    	'Estimate' => $r->field( $h, 'estimate_id', $estimate_criteria),
       	'Description' => $r->field( $h, 'description'),
        'Staff' => $r->field( $h, 'staff_id'),
        'Hours' => $r->field( $h, 'hours'),        
        'Discount' => $r->field( $h, 'discount'),
		'Basecamp ID' => $r->field( $h, 'basecamp_id')
    );
    $form_contents = $r->view( 'basicList', $list_items) . $r->submit();
    
    return $r->form( 'post', 'HourEdit', $form_contents, array( 'redirect' => $r->url('HourEdit',$h)));
}
?>
