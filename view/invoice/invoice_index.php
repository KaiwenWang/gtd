<?php
function invoiceIndex($d, $o = array() ) {
    $r = getRenderer();

	$hidden_forms = $r->view('jsMultipleButtons',
							array(	
								'Create Single Invoice' => $r->view('invoiceNewForm',$d->new_invoice),
								'Create Quarterly Invoices' => $r->view('invoicebatchNewForm',$d->new_batch)
								)
							);

	$invoice_table = $r->view('invoiceTable',$d->invoices);
    return array( 
        'title' => 'Show Invoices', 
        'body' =>  	$hidden_forms
					.$invoice_table
                );
}
