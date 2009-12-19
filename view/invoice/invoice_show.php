<?php

function invoiceShow($d, $o = array() ) {
    $r = getRenderer();
    $project_hours = $d->company->getProjectHours();
    $project_charges = $d->company->calculateProjectCharges($project_hours);
    $support_hours = $d->company->getSupportHours();
    $support_charges = $d->company->calculateSupportCharges($support_hours);
    $total_addons = $d->company->getChargesTotal(); 
    $payments_to_date = $d->company->getPaymentsTotal();
    // and here we calculate all the shit we calculated above, YET AGAIN. 
    // pretty inefficient.
    $total = "$ " . number_format($d->invoice->getAmount(), 2);
    $items = array(
        'Project charges' => $project_charges,
        'Support charges' => $support_charges,
        'Addon charges' => $total_addons,
        'Total Payments' => $payments_to_date,
        'Total Due' => $total
        );
    $invoice_items = $r->view('chargeTable', $d->charges, $o )
                    .$r->view('hourTable', $d->project_hours, $o)
                    .$r->view('supporthourTable', $d->support_hours, $o);
    return array( 
        'title' => 'Show Invoice', 
        'body' => $r->view('basicList', $items )
                    . $invoice_items
    );
}
