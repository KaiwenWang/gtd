<?php

function invoiceShow($d, $o = array() ) {
    $project_hours = $d->invoice->getProjectHours();
    $project_charges = $d->invoice->calculateProjectCharges($project_hours);
    $support_hours = $d->invoice->getSupportHours();
    $support_charges = "Support: " . $d->invoice->calculateSupportCharges($support_hours);
    $total_addons = "Addons: " .$d->invoice->getChargesTotal(); 
    $payments_to_date = "Payments: " . $d->invoice->getPaymentsTotal() . "\n";
    return array( 'title' => 'Show Invoice', 
                  'body' => ' you owe us $ ' . number_format($d->invoice->getAmount(), 2));
}
