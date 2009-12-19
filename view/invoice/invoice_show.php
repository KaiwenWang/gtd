<?php
function invoiceShow($d, $o = array() ) {
    $r = getRenderer();
    $date_range = array( 'for_date_range' => 
        array( 'start_date' => $d->invoice->get('start_date'), 'end_date' => $d->invoice->get('end_date')));
    $project_hours = $d->company->getProjectHours( $date_range );
    $project_charges = $d->company->calculateProjectCharges($project_hours);
    $support_hours = $d->company->getSupportHours( $date_range );
    $support_charges = $d->company->calculateSupportCharges($support_hours);

    $total = $d->invoice->getAmount();
    $invoice_period = date('M jS, Y', strtotime($d->invoice->get('start_date'))) 
        . " through " 
        . date('M jS, Y', strtotime($d->invoice->get('end_date')));  
    $last_payment = array_shift($d->company->getPayments());
    $last_payment_date = date('M jS, Y', strtotime( $last_payment->get('date')));
    $prior_balance = $d->company->getBalance( $d->invoice->get('start_date'));
    $items = array(
        'Client'            => $d->company->getName(),
        'Invoice Date'      => $d->invoice->get('date') ? date('M jS, Y', $d->invoice->get('date')) : date('M jS, Y'),
        'Items for Period'  => $invoice_period,
        'Last Payment'      => " $ " . number_format( $last_payment->getAmount(), 2) . ' on '.  $last_payment_date ,
        'Previous Balance'  => "$ " . number_format( $prior_balance, 2), 
        'New Charges'       => "$ " . number_format( $total - $prior_balance, 2 ),
        'Total Due'         => "$ " . number_format($total, 2)
        );

    $summary = '
                <div id="invoice-summary">
                    '.$r->view('basicList', $items ).'
                </div>
                ';

    $charges_table = '
                         <div id="invoice-charges">
                            '.$r->view('chargeTable', $d->charges, array_merge( $o, array('title' => 'Other Items') )).'
                        </div>
                        ';

    $project_hour_table = '
                        <div id="invoice-project-hours">
                            '.$r->view('hourTable', $d->project_hours, array_merge($o, array('title' => 'Project Hours'))).'
                        </div>
                         ' . '<div class="totals-data"><h3 class="basic-table-header">Project Charges: $ ' . number_format($project_charges, 2). '</h3></div>';
    $support_hour_table = ' 
                         <div id="invoice-support-hours">
                            '.$r->view('supporthourTable', $d->support_hours, $o).'
                         </div>
                         ' . '<div class="totals-data"><h3 class="basic-table-header">Support Charges: $ ' . number_format($support_charges, 2). '</h3></div>';
    return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
        'body' =>   $summary
                    .$project_hour_table
                    .$support_hour_table
                    .$charges_table
                );
}
