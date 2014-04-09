<?php

function invoiceEmailPlain($d, $o = array()) {
  $r = getRenderer();

  if ($d->invoice->getData('type') == 'dated') {
    $invoice_date = $d->invoice->getEndDate();
  } else {
    $invoice_date = $d->invoice->getDate();
  }

  $invoice_period = $d->invoice->getStartDate() 
    . " through " 
    . $d->invoice->getEndDate();

  $client = $d->company->getName();  

  $summary = "\n\nRadical Designs Invoice\n Invoice Date " .  $invoice_date ."\n Invoice Number #" .  $d->invoice->getData("id") ."\n Your New Radical Designs Invoice: ".$client."\n\n ";
  if ($d->invoice->getData('type') == 'dated') {
    $summary .= "Invoice for Period ". $invoice_period ."\n\n Starting Balance on " . $d->invoice->getStartDate() . ":\n $ " . number_format($d->invoice->getPreviousBalance(), 2)." New Charges in Period:\n  $ " . number_format($d->invoice->getNewCosts(), 2) ."\n\n Less Payments in Period:\n $ " . number_format($d->invoice->getNewPaymentsTotal(), 2) ."\n";
  }

  if ($d->invoice->getData('details')) {
    $summary .= "Details: ".$d->invoice->getData("details")."\n";
  }  

  $summary .= " Current Total Due: $ " . number_format($d->invoice->getAmountDue(), 2) . "\n\nNet 30 Terms\n\nPayment Information:\n\n"; 

  if ($d->invoice->getAmountDue() < 1000) { 
    $summary .= "Radical Designs accepts online payments at https://payments.rdsecure.org/payments for amounts less than $1000.\n\n";
  }
  $summary .= "Send checks to:\n Radical Designs\n 1201 Martin Luther King Jr. Way, Suite 200 \n Oakland, CA\n 94612\n \n Make your check payable to Radical Designs. \n For questions about your contract or bill please email billing@radicaldesigns.org\n For questions about support please email help@radicaldesigns.org\n Or you can call us at 415-738-0456"; 

  $summary .= $r->view('companyLineItemsPlain', array(
    'company' => $d->company,
    'months' => Util::month_range(
      $d->invoice->getStartDate(),
      $d->invoice->getEndDate()
    )
  ));

  return array(
    'template' => 'invoice',
    'title' => 'Show Invoice', 
    'body' =>   $summary
  );
}

?>
