<?php

function invoiceShow($d, $o = array() ) {
    return array( 'title' => 'Show Invoice', 
                  'body' => ' you owe us $ ' . number_format($d->invoice->getAmount(), 2));
}
