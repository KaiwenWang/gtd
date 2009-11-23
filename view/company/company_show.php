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
															  $d->new_project)
						)
					);
					
	$project_table = $r->view( 'contactTable', $d->company->getContacts());
	$contact_table = $r->view( 'projectTable', $d->company->getProjects());
	
	return  array(
		'title' => $d->company->getName(),
		'controls' => $company_selector,
		'body' =>   $editable_project_info
					.$hidden_forms
					.$project_table
					.$contact_table
	);	
}
?>