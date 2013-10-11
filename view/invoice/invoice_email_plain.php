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

    $summary = "\n\nRadical Designs Statement\n Statement Date " .  $invoice_date ."\n Statement Number #" .  $d->invoice->getData("id") ."\n Your New Radical Designs Statement: ".$client."\n\n ";
    $summary .= '**Radical Designs has moved! Please note our new address: 1201 Martin Luther King Jr. Way Suite 200, Oakland, CA 94612**';
    if ($d->invoice->getData('type') == 'dated'){
        $summary .= "Statement for Period ". $invoice_period ."\n\n Starting Balance on " . $d->invoice->getStartDate() . ":\n $ " . number_format( $d->invoice->getPreviousBalance(), 2)." New Charges in Period:\n  $ " . number_format( $d->invoice->getNewCosts(), 2 ) ."\n\n Less Payments in Period:\n $ " . number_format( $d->invoice->getNewPaymentsTotal(), 2 ) ."\n";
    }

    if ($d->invoice->getData('details')){
        $summary .= "Details: ".$d->invoice->getData("details")."\n";
    }  

    $summary .= " Current Total Due: $ " . number_format( $d->invoice->getAmountDue(), 2) . "\n\nPayment Information:\n\n"; 

    if ($d->invoice->getAmountDue() < 1000) { 
        $summary .= "Radical Designs accepts online payments at https://payments.rdsecure.org/payments for amounts less than $1000.\n\n";
    }
    $summary .= "Send checks to:\n Radical Designs\n 1201 Martin Luther King Jr. Way, Suite 200 \n Oakland, CA\n 94612\n \n Make your check payable to Radical Designs. \n For questions about your contract or bill please email billing@radicaldesigns.org\n For questions about support please email help@radicaldesigns.org\n Or you can call us at 415-738-0456"; 

    $summary .= $r->view( 'companyLineItemsPlain', array(
        'company'=>$d->company,
        'months'=>Util::month_range(
            $d->invoice->getStartDate(),
            $d->invoice->getEndDate()
        )));

    //temporary message for new status
/*	$summary .= "*Important Special Message*\nRadical Designs is very excited to announce a important transition in our company. As you may know Radical Designs was originally organized as a limited liability corporation but has always acted in a democratic and cooperative fashion. In order to bring the company in-line with our values Radical Designs recently reorganized as a worker cooperative. 
                \n\n
                As a practical matter this will have no impact on your services with us but it will mean some minor adjustments to our billing and tax information. 
                \n\n
                For your tax records we will be issuing a new W-9 with our new FEIN for the last quarter of 2010. The first three quarters will be under the old W-9/ FEIN number.
                \n\n
                        In addition to re-organizing as a worker coop we are are excited to integrate credit card billing as an option for your payments. If your balance is less than $1000, simply follow the link above in order to pay by card. 
                \n\n		
                        Best regards,
                \n\n		
                Radical Designs Cooperative	";
 */
    return array( 
        'template' => 'invoice',
        'title' => 'Show Statement', 
        'body' =>   $summary
    );
}
