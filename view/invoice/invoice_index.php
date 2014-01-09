<?php
function invoiceIndex($d, $o = array() ) {
    $r = getRenderer();

    $hidden_forms = $r->view('jsMultipleButtons',
        array(	
            'Create Single Statement' => $r->view('invoiceNewForm',$d->new_invoice),
            'Create Quarterly Statements' => $r->view('invoicebatchNewForm',$d->new_batch),
            'Create Stand-Alone Statement' => $r->view('invoiceStandNewForm',$d->new_stand_invoice)
        )
    );

    $invoice_table = $r->view( 'invoiceTable',
        $d->invoices, 
        array( 'search_invoice'=>$d->search_invoice	)
    );

    return array( 
        'title' => 'Show Statements', 
        'body' =>  	$hidden_forms
        .$invoice_table
    );
}
