<?php
function invoiceShow($d, $o = array() ) {
    $r = getRenderer();

    $invoice_period = $d->invoice->getStartDate() 
		      . " through " 
		      . $d->invoice->getEndDate();

    $banner = array(
		'Invoice Date'      => $d->invoice->getEndDate(),
		'Invoice Number'      => "#" . $d->invoice->getData('id')
		);

    $client = $d->company->getName();  

    $items = array(
        'Items for Period'  => $invoice_period,
        'Previous Balance'  => "$ " . number_format( $d->invoice->getPreviousBalance(), 2), 
        'New Charges'       => "$ " . number_format( $d->invoice->getNewCosts(), 2 ),
        'New Payments'      => "$ " . number_format( $d->invoice->getNewPaymentsTotal(), 2 ),
        'Total Due'         => "$ " . number_format( $d->invoice->getAmountDue(), 2)
        );
 
    $summary = '
		<div id="banner">'.$r->view('basicList', $banner).'</div>
		<h2 id="invoice-client">'.$client.'</h2>
        <div id="invoice-summary">
			'.$r->view('basicList', $items ).'
		</div>';

    $history = $r->view( 'historyTable', $d->company->getHistory( ));

    return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
		'body' =>   $summary,
		'history' => $history
                );
}
