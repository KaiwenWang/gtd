<?php
function companyShow($d){
	$r = getRenderer();
	
	$company_selector = $r->view( 'jumpSelect', $d->company );
	
	$editable_project_info = $r->view( 'jsSwappable',
									  'Company Info',
					 				   array(
						 				$r->view( 'companyInfo', $d->company),
										$r->view( 'companyEditForm' , $d->company)
										)
									);
	
	$hidden_forms = $r->view('jsHideable',
						array(
							'Create New Project' => $r->view( 'projectNewForm', 
															  $d->new_project),
                            'Add Charge' => $r->view( 'chargeNewForm',
                                                            $d->new_charge ),
                            'Add Payment' => $r->view( 'paymentNewForm',
                                                            $d->new_payment),
                            'Create Standard Invoice' => $r->view( 'invoiceNewForm',
                                                            $d->new_invoice)
						)
					);
					
	$project_table = $r->view( 'projectTable', $d->company->getProjects());
	$contract_table = $r->view( 'supportcontractTable', $d->company->getSupportContracts());
	$contact_table = $r->view( 'contactTable', $d->company->getContacts());
    $charge_table= $r->view( 'chargeTable', $d->company->getCharges( ));
    $payment_table= $r->view( 'paymentTable', $d->company->getPayments( ));
    $invoice_table= $r->view( 'invoiceTable', $d->company->getInvoices( ));
	
	return  array(
		'title' => $d->company->getName(),
		'controls' => $company_selector,
		'body' =>   $editable_project_info
					.$hidden_forms
					.$project_table
					.$contract_table
					.$contact_table
					.$charge_table
					.$payment_table
                    .$invoice_table
	);	
}
