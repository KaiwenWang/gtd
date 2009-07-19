<?php

function jumpSelect( $sample_object, $criteria = array( )) {
    $r =& getRenderer( );
    $selector = $r->objectSelect( $sample_object, array( 'name' => 'id'), $criteria );
    $selector .= $r->submit( );
    return $r->form( 'get', get_class( $sample_object ) . 'Detail', $selector );
}


?>
