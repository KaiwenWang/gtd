<?php
function invoiceShow($d, $o = array() ) {
    $r = getRenderer();

    if ($d->invoice->getData('type') == 'dated'){
        $invoice_date = $d->invoice->getEndDate();
    } else {
        $invoice_date = $d->invoice->getDate();
    }

    $invoice_period = $d->invoice->getStartDate() 
        . " through " 
        . $d->invoice->getEndDate();

    $banner = array(
        'Invoice Date'      => $invoice_date, 
        'Invoice Number'      => "#" . $d->invoice->getData('id')
    );

    $client = $d->company->getName();  
    $billing_contact_emails = $d->company->getBillingEmailAddress();
    $additional_recipients = $d->invoice->getAdditionalRecipients();
    $send_button = UI::button( array(   'controller'=>'Invoice',
        'action'=>'email',
        'id'=>$d->invoice->getData('id')
    )); 
    if ($d->invoice->getData('type') == 'dated'){	
        $items = array(
            'Items for Period'  => $invoice_period,
            'Previous Balance'  => "$ " . number_format( $d->invoice->getPreviousBalance(), 2), 
            'New Payments in Period'      => "$ " . number_format( $d->invoice->getNewPaymentsTotal(), 2 ),
            'New Charges in Period'       => "$ " . number_format( $d->invoice->getNewCosts(), 2 ),
            'Total Due'         => "$ " . number_format( $d->invoice->getAmountDue(), 2),
            'Net 30 Terms' => ' '
        );
    } else {
        $items = array(
          'Total Due'         => "$ " . number_format( $d->invoice->getAmountDue(), 2),
          'Net 30 Terms' => ' '
        );
    } 

    $summary = '
        <div id="banner">'.$r->view('basicList', $banner).'</div>
        <h2 id="invoice-client">'.$client.'</h2>
        <div id="billing-contact">Billing Contact Email: '.$billing_contact_emails.$additional_recipients.'<br>
        </div>
        <div id="billing-send-invoice">'.$send_button.'</div>
        <div id="invoice-summary">';
    if ($d->invoice->getData('details')){
        $summary .= '<div id="details"><strong>Details</strong>: ' . nl2br($d->invoice->getData('details')) . '</div>';
    }

    $summary .=		
        $r->view('basicList', $items ).'
        </div>';

    $history = $r->view( 'companyLineItems', array(
        'company'=>$d->company,
        'dates'=>array(
            'start_date' => $d->invoice->getStartDate(),
            'end_date' => $d->invoice->getEndDate()
        )));

    return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
        'body' =>   $summary,
        'history'=>	$history
    );
}
