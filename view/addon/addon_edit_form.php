<?php

function addonEditForm( $addon, $o = array(  )) {
    $r = getRenderer(  );
    return $r->view( 'addonNewForm', $addon, array( 'action' => 'update' ) );
}
