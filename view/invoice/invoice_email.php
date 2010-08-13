<?php
function invoiceEmail($d, $o = array() ) {
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

    $summary = '
		<div id="banner">
		<img src="http://radicaldesigns.org/img/original/rd-invoice-header.gif"><br />
		<b>Invoice Date</b> ' .  $invoice_date . '<br />
		<b>Invoice Number #' .  $d->invoice->getData('id') .'</b>
		</div>
		<h2 id="invoice-client">Your New Radical Designs Invoice: '.$client.'</h2>
		<div id="invoice-summary">';

	if ($d->invoice->getData('type') == 'dated'){
		$summary .= '
		<b>Invoice for Period '. $invoice_period .'</b><br /><br /> 
        <b>Starting Balance on ' . $d->invoice->getStartDate() . ':</b><br /> $ ' . number_format( $d->invoice->getPreviousBalance(), 2).'<br /><br /> 
        <b>New Charges in Period:</b><br />  $ ' . number_format( $d->invoice->getNewCosts(), 2 ) .'<br /><br />
		<b>Less Payments in Period:</b><br />  $ ' . number_format( $d->invoice->getNewPaymentsTotal(), 2 ) .'<br />';
	}

	if ($d->invoice->getData('details')){
	     $summary .= '<div id="details"><strong>Details</strong>: '.$d->invoice->getData('details').'</div>';
	}  

	$pay_online = 'https://www.paypal.com/cgi-bin/webscr?amount=' . number_format( $d->invoice->getAmountDue(), 2) . '&no_shipping=1&image_url=https%3A//radicaldesigns.rdsecure.org/img/original/rd-invoice-header.gif&return=http%3A//radicaldesigns.org&item_name=Internet+Hosting&business=billing%40radicaldesigns.org&invoice=' .  $d->invoice->getData('id') .'&cmd=_xclick&no_note=1';	

	$summary .= '
        <h3>Current Total Due: $ ' . number_format( $d->invoice->getAmountDue(), 2) . '</h3>
		<!-- <div>View charges and detailed history online at <a href=""> http://???</a></div> -->
		<hr>
		<h4>Payment Information</h4>';
	if ($d->invoice->getAmountDue() < 1000) {
		$summary .= '<strong><a href="'.$pay_online.'">Pay this amount online</a></strong><br /><br />';
	}
	$summary .= '<strong>Send checks to: </strong>Radical Designs<br />
				1370 Mission St, 4th Floor<br />
				San Francisco, CA 94103<br /><br />
			<b>Payment Methods: </b>&nbsp;&nbsp;Radical Designs accepts checks, or
			credit/debit cards and bank account transfers via <a href="http://paypal.com">PayPal</a> for payments under $1000.  Click above to pay your current balance online, or mail a check to the address above.  Make your check
			payable to "Radical Designs". <br />
			For questions about your contract or bill please email <a href="mailto:billing@radicaldesigns.org">billing@radicaldesigns.org</a><br>
			For questions about support please email <a href="mailto:help@radicaldesigns.org">help@radicaldesigns.org</a><br>
			Or you can call us at 415-738-0456 
		</div>';

	$history = $r->view( 'historyTable', $d->company->getHistory( ));

    return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
		'body' =>   $summary,
                );
}
