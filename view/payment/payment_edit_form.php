<?php

function paymentEditForm( $payment, $o = array(  ) ) {
    $r = getRenderer();
    return $r->view('paymentNewForm', $payment, array('action' => 'update'));
}
