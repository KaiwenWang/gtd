<?php
function invoiceShow($d, $o = array() ) {
    $r = getRenderer();

    $total = $d->invoice->getAmountDue();

    $invoice_period = $d->invoice->getStartDate() 
			        	. " through " 
        				. $d->invoice->getEndDate();

    $items = array(
        'Client'            => $d->company->getName(),
        'Invoice Date'      => $d->invoice->getEndDate(),
        'Items for Period'  => $invoice_period,
        'Previous Balance'  => "$ " . number_format( $d->invoice->getPreviousBalance(), 2), 
        'New Charges'       => "$ " . number_format( $d->invoice->getNewCosts(), 2 ),
        'New Payments'       => "$ " . number_format( $d->invoice->getNewPaymentsTotal(), 2 ),
        'Total Due'         => "$ " . number_format( $d->invoice->getAmountDue(), 2)
        );

    $summary = '
                <div id="invoice-summary">
                    '.$r->view('basicList', $items ).'
                </div>
                ';

    return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
        'body' =>   $summary
                );
}
