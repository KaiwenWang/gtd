<?php

function chargeEditForm( $charge, $o = array(  )) {
    $r = getRenderer(  );
    return $r->view( 'chargeNewForm', $charge, array( 'action' => 'update' ) );
}
