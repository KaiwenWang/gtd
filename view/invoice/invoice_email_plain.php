<?php
function invoiceEmailPlain($d, $o = array() ) {
    $r = getRenderer();

	if ($d->invoice->getData('type') == 'dated'){
		$invoice_date = $d->invoice->getEndDate();
	} else {
		$invoice_date = $d->invoice->getDate();
	}

    $invoice_period = $d->invoice->getStartDate() 
		      . " through " 
		      . $d->invoice->getEndDate();
   
    $client = $d->company->getName();  

    $summary = "\n\nRadical Designs Invoice\n Invoice Date " .  $invoice_date ."\n Invoice Number #" .  $d->invoice->getData("id") ."\n Your New Radical Designs Invoice: ".$client."\n\n ";

	if ($d->invoice->getData('type') == 'dated'){
		$summary .= "Invoice for Period ". $invoice_period ."\n\n Starting Balance on " . $d->invoice->getStartDate() . ":\n $ " . number_format( $d->invoice->getPreviousBalance(), 2)." New Charges in Period:\n  $ " . number_format( $d->invoice->getNewCosts(), 2 ) ."\n\n Less Payments in Period:\n $ " . number_format( $d->invoice->getNewPaymentsTotal(), 2 ) ."\n";
	}

	if ($d->invoice->getData('details')){
	     $summary .= "Details: ".$d->invoice->getData("details")."\n";
	}  
	
	$summary .= " Current Total Due: $ " . number_format( $d->invoice->getAmountDue(), 2) . "\n\nPayment Information:\n\n"; 
		
	if ($d->invoice->getAmountDue() < 1000) { 
		$summary .= "Radical Designs accepts payments via http://paypal.com for amounts less than $1000. Make payments to billing@radicaldesigns.org.\n\n";
	}
	$summary .= "Send checks to:\n Radical Designs\n 1370 Mission St, 4th Floor\n San Francisco, CA 94103. \n Make your check payable to Radical Designs. \n For questions about your contract or bill please email billing@radicaldesigns.org\n For questions about support please email help@radicaldesigns.org\n Or you can call us at 415-738-0456"; 
	
	return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
		'body' =>   $summary,
                );
}
