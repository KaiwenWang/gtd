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

//	$pay_online = 'https://www.paypal.com/cgi-bin/webscr?amount=' . number_format( $d->invoice->getAmountDue(), 2) . '&no_shipping=1&image_url=https%3A//radicaldesigns.rdsecure.org/img/original/rd-invoice-header.gif&return=http%3A//radicaldesigns.org&item_name=Internet+Hosting&business=billing%40radicaldesigns.org&invoice=' .  $d->invoice->getData('id') .'&cmd=_xclick&no_note=1';	
	$pay_online = 'https://payments.rdsecure.org/payments';

	$summary .= '
        <h3>Current Total Due: $ ' . number_format( $d->invoice->getAmountDue(), 2) . '</h3>
		<!-- <div>View charges and detailed history online at <a href=""> http://???</a></div> -->
		<hr>
		<h4>Payment Methods</h4>';
	if ($d->invoice->getAmountDue() < 1000) {
		$summary .= 'Radical Designs accepts credit/debit cards online for payments under $1000. <strong><a href="'.$pay_online.'">Pay your balance online</a></strong><br /><br />';
	}
	$summary .= '<strong>Send checks to: </strong>Radical Designs<br />
				1370 Mission St, 4th Floor<br />
				San Francisco, CA 94103<br />
				Make checks payable to "Radical Designs". <br /><br />
			For questions about your contract or bill please email <a href="mailto:billing@radicaldesigns.org">billing@radicaldesigns.org</a><br>
			For questions about support please email <a href="mailto:help@radicaldesigns.org">help@radicaldesigns.org</a><br>
			Or you can call us at 415-738-0456 
		</div>';

	//temporary message for new status
	$summary .= '<hr><h4>*Important Special Message*</h4>Radical Designs is very excited to announce a important transition in our company. As you may know Radical Designs was originally organized as a limited liability corporation but has always acted in a democratic and cooperative fashion. In order to bring the company in-line with our values Radical Designs recently reorganized as a worker cooperative. 
		<br /><br />
		As a practical matter this will have no impact on your services with us but it will mean some minor adjustments to our billing and tax information. 
		<br /><br />
		<strong>For your tax records we will be issuing a new W-9 with our new FEIN for the last quarter of 2010. The first three quarters will be under the old W-9/ FEIN number. </strong>
		<br /><br />
			In addition to re-organizing as a worker coop we are are excited to integrate credit card billing as an option for your payments. If your balance is less than $1000, simply follow the link above by your balance to in order to pay by card. 
		<br /><br />
			Best regards,
		<br /><br />
		Radical Designs Cooperative	';

	$history = $r->view( 'historyTable', $d->company->getHistory( ));

    return array( 
        'template' => 'invoice',
        'title' => 'Show Invoice', 
		'body' =>   $summary,
                );
}
