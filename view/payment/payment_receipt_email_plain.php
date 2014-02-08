<?php
function paymentReceiptEmailPlain($d, $o = array()) {
  $r = getRenderer();

  $payment_date = $d->payment->getDate();
  $payment_amount= $d->payment->getAmount();
  $client = $d->payment->getCompanyName();  
  $billing_email = $d->payment->getBillingEmailAddress();
  $summary = "
    Your Radical Designs Payment Receipt: " . $client . "\n
    Payment Date " .  $payment_date . "\n
    Invoice Number #" .  $d->payment->getInvoiceId() . "\n
    Payment Amount $" . $payment_amount . "
    Billing Contact:" .$billing_name . ", " . $billing_email . "\n\n
    Thank you for your business and your work!</h4><h4>Radical Designs\n\n
    For questions regarding billing please contact billing@radicaldesigns.org if you have questions or concerns. For technical or service needs please contact help@radicaldesigns.org or call 415.738.0456";
  
  return array(
    'template' => 'payment',
    'title' => 'Show payment', 
    'body' => $summary
  );
}

?>
