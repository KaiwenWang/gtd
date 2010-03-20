<?php
function invoiceIndex($d, $o = array() ) {
    $r = getRenderer();

	$invoice_table = $r->view('invoiceTable',$d->invoices);
	$invoice_new_form = $r->view('invoiceNewForm',$d->new_invoice);
    return array( 
        'title' => 'Show Invoices', 
        'body' =>  $invoice_new_form . $invoice_table 
                );
}
