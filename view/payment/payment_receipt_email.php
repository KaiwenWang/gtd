<?php
function paymentReceiptEmail($d, $o = array() ) {
    $r = getRenderer();

	$payment_date = $d->payment->getDate();
	$payment_amount= $d->payment->getAmount();
    $client = $d->payment->getCompanyName();  
	$billing_email = $d->payment->getBillingEmailAddress();
    $summary = '
		<div id="banner">
		<img src="http://radicaldesigns.org/img/original/rd-payment-header.gif"><br />
		<h2 id="payment-client">Your Radical Designs Payment Receipt: '.$client.'</h2>
		<b>Payment Date</b> ' .  $payment_date . '<br />
		<b>Invoice Number #' .  $d->payment->getInvoiceId() .'</b><br />
		<h3>Payment Amount $'. $payment_amount .'</h3>
		</div>
		<hr>
		<div id="billing-contacts">
		Billing Contact:'.$billing_name.', '.$billing_email.'
		</div>
		<h4>Thank you for your business and your work!</h4><h4>Radical Designs</h4>
		<div id="payment-summary">
		For questions regarding billing please contact <a href="billing@radicaldesigns.org">billing@radicaldesigns.org</a> if you have questions or concerns. For technical or service needs please contact <a href="help@radicaldesigns.org">help@radicaldesigns.org</a> or call 415.738.0456</div>';
	
	    return array( 
        'template' => 'payment',
        'title' => 'Show payment', 
		'body' =>   $summary
                );
}
