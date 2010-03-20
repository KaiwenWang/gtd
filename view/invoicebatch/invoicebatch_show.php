<?php
function invoicebatchShow($d,$o=array()){
	$r = getRenderer();

	$invoice_table = $r->view('invoiceTable',$d->invoices);

	return array(
			'title' => $d->batch->getName(),
			'body' => $invoice_table
			);
}
