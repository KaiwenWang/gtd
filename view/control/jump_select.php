<?php

function jumpSelect( $sample_object, $criteria = array( )) {
    $r =& getRenderer( );
    $selector = $r->objectSelect( $sample_object, array( 'name' => 'id'), $criteria );
    $selector .= $r->input('hidden',array('name'=>'action','value'=>'show'));
    $selector .= $r->submit( );
    return $r->form( 
				'method'=>'get', 
				'action'=>'show',
				'controller'=>get_class( $sample_object ), 
				'content'=>$selector
				);
}


?>
