<?php
function companyNewForm( $c, $o = array()){
    $r =& getRenderer();
    $list_items = array(
		'Name' => $r->field( $c, 'name'),
		'Notes' =>$r->field( $c, 'notes'),
		'Street' => $r->field( $c, 'street'),
		'Street 2'=> $r->field( $c, 'street_2'),
		'City'=> $r->field( $c, 'city'),
		'State'=> $r->field( $c, 'state'),
		'Zip'=> $r->field( $c, 'zip'),
		'Phone'=> $r->field( $c, 'phone'),
		'Product'=> $r->field( $c, 'product'),
		'Status'=> $r->field( $c, 'status')
	);	
    
    $form_contents = $r->view( 'basicList', 
    							$list_items, 
    							array( 'title'=>'Add Company', 'display'=>'inline')
    						  );
    						  		  
    $o['method'] = 'post';
    
    return $r->form( 'create', 'Company', $form_contents.$r->submit(), $o);
}
?>