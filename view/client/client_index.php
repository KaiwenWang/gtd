<?php

function ClientIndex($d) {
	$r =& getRenderer();

    $company_info = $r->view( 'clientCompanyInfo', 	$d->company);
    $invoice_table = $r->view( 'clientInvoiceTable', 	$d->company->getInvoices());
    $payment_table = $r->view( 'clientPaymentTable', 	$d->company->getPayments());
	$output = 'test';
	return 	array(
						'template' => 'gtd_client_template',
                        'title'=>'Summary',
                        'controls'=>'',
                        'body'=>
						$company_info .
						$invoice_table .
						$payment_table
                    	);

}	
