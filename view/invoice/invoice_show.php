<?php

function invoiceShow($d, $o = array() ) {
    $r = getRenderer();
    $total = $d->invoice->getAmountDue();

    $invoice_period = $d->invoice->getStartDate() 
			        	. " through " 
        				. $d->invoice->getEndDate();
	$banner = array(
		'Invoice Date'      => $d->invoice->getEndDate(),
		'Invoice Number'      => "#" . $d->invoice->getData('id')
		);
    $items = array(
        ''            => $d->company->getName(),
        'Items for Period'  => $invoice_period,
        'Previous Balance'  => "$ " . number_format( $d->invoice->getPreviousBalance(), 2), 
        'New Charges'       => "$ " . number_format( $d->invoice->getNewCosts(), 2 ),
        'New Payments'       => "$ " . number_format( $d->invoice->getNewPaymentsTotal(), 2 ),
        'Total Due'         => "$ " . number_format( $d->invoice->getAmountDue(), 2)
        );

    $summary = '
				<div id="banner">'.$r->view('basicList', $banner).'</div>
                <div id="invoice-summary">
                    '.$r->view('basicList', $items ).'
                </div>
                ';

    return array( 
        'title' => 'Show Invoice', 
        'body' => $r->view('basicList', $items )
                    . $invoice_items
    );
}
