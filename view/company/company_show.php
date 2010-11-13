<?php
function companyShow($d){
	$r = getRenderer();
	
	$company_selector = $r->view( 'jumpSelect', $d->company );
	
	$editable_company_info = $r->view('jsSwappable',
									  'Company Info',
					 				   array(
						 				$r->view( 'companyInfo', $d->company),
										$r->view( 'companyEditForm' , $d->company)
										)
									);
	
	$hidden_forms = $r->view('jsMultipleButtons',
						array(
							'Create New Contact' => $r->view( 'contactNewForm', $d->new_contact),
							'Create New Project' => $r->view( 'projectNewForm', $d->new_project),
                            'Add Charge' 		 => $r->view( 'chargeNewForm', $d->new_charge),
                            'Add Payment' 		 => $r->view( 'paymentNewForm', $d->new_payment),
                            'Create Standard Invoice' => $r->view( 'invoiceNewForm', $d->new_invoice)
							)
						);
					
	$project_table = $r->view( 'projectTable', 	$d->company->getProjects());
	$contract_table= $r->view( 'supportcontractTable', $d->company->getSupportContracts());
	$contact_table = $r->view( 'contactTable', 	$d->company->getContacts());
    $charge_table  = $r->view( 'chargeTable', 	$d->company->getCharges());
    $payment_table = $r->view( 'paymentTable', 	$d->company->getPayments());
    $invoice_table = $r->view( 'invoiceTable', 	$d->company->getInvoices());
	$history_table = $r->view( 'historyTable', 	$d->company->getHistory());


	// monthly history
	$active_months = $d->company->getActiveMonths();
	$monthly_history = '';
	foreach($active_months as $active_month) {
		$monthly_total = 0;

		// support contracts
		$support_contracts_output = '';
		$support_contracts = $d->company->getSupportContracts();
		foreach($support_contracts as $support_contract) {
			$name = $support_contract->getName();
			$monthly_rate = $support_contract->get('monthly_rate');
			$support_hours = $support_contract->get('support_hours');
			$hourly_rate = $support_contract->get('hourly_rate');
			$monthly_total += $monthly_rate;

			// get all the hours
			$hours = $support_contract->getHours( array( 
				'date_range' => array(
					'start_date' => $active_month.'-01', // first day of the month
					'end_date' => $active_month.'-'.date("t", strtotime($active_month)) // last day of the month
				)
			));

			// add them up
			$number_of_hours = 0;
			foreach($hours as $hour) { $number_of_hours += $hour->getHours(); }

			// calculate the total
			$hours_total = ($number_of_hours * $hourly_rate) - ($support_hours * $hourly_rate);
			if($hours_total < 0) $hours_total = 0; // if they didn't use their support hours
			$monthly_total += $hours_total;

			$support_contracts_output .= "<tr>";
			$support_contracts_output .= "  <td> $name Hosting </td>";
			$support_contracts_output .= "  <td></td>";
			$support_contracts_output .= "  <td> \$ $monthly_rate </td>";
			$support_contracts_output .= "</tr>";
			$support_contracts_output .= "<tr>";
			$support_contracts_output .= "  <td> $name </td>";
			$support_contracts_output .= "  <td> $number_of_hours - $support_hours  </td>";
			$support_contracts_output .= "  <td> \$ $hours_total </td>";
			$support_contracts_output .= "</tr>";
		}

		// projects
		$projects_output = '';
		$projects = $d->company->getProjects();
		foreach($projects as $project) {
			$name = $project->getName();
			$hourly_rate = $project->get('hourly_rate');

			// get all the hours
			$hours = $project->getHours( array( 
				'date_range' => array(
					'start_date' => $active_month.'-01', // first day of the month
					'end_date' => $active_month.'-'.date("t", strtotime($active_month)) // last day of the month
				)
			));

			// add them up
			$number_of_hours = 0;
			foreach($hours as $hour) { $number_of_hours += $hour->getHours(); }

			// calculate the total
			$hours_total = $number_of_hours * $hourly_rate;
			$monthly_total += $hours_total;

			$projects_output .= "<tr>";
			$projects_output .= "  <td> $name </td>";
			$projects_output .= "  <td> $number_of_hours </td>";
			$projects_output .= "  <td> \$ $hours_total </td>";
			$projects_output .= "</tr>";
		}

		// build the display
		$monthly_history .= "<fieldset style=\"width:500px; margin: 0 auto 10px auto;\">";
		$monthly_history .= "  <legend style=\"font-weight: bold;\"> $active_month </legend>";
		$monthly_history .= "  <table style=\"width: 100%\">";
		$monthly_history .= "    <tr>";
		$monthly_history .= "      <td></td>";
		$monthly_history .= "      <td style=\"font-weight:bold; font-size:.8em;\">Hours</td>";
		$monthly_history .= "      <td style=\"font-weight:bold; font-size:.8em;\">Price</td>";
		$monthly_history .= "    </tr>";
		$monthly_history .= "	$support_contracts_output";
		$monthly_history .= "	$projects_output";
		$monthly_history .= "    <tr>";
		$monthly_history .= "      <td style=\"font-weight:bold; font-size:.8em;\">TOTAL</td>";
		$monthly_history .= "      <td></td>";
		$monthly_history .= "      <td style=\"font-weight:bold;\">\$ $monthly_total </td>";
		$monthly_history .= "    </tr>";
		$monthly_history .= "  </table>";
		$monthly_history .= "</fieldset>";
	}
	
	return  array(
		'title' => $d->company->getName(),
		'controls' => $company_selector,
		'body' =>  $editable_company_info
					.$hidden_forms
					.$contact_table
					.$contract_table
					.$project_table
					.$charge_table
					.$payment_table
                    .$invoice_table
					.$history_table
					.$monthly_history
	);	
}
