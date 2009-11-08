<?php
function companyShow($d){
  $r =& getRenderer();

  $company_selector = $r->view( 'jumpSelect', $d->company );
    	
  $html = $r->view( 'companyInfo', $d->company);

  $html .= $r->view('jsHideable',
  					array(
  						'Create New Project' => $r->view( 'projectNewForm', $d->new_project)
  					)
  				);
  $html .= $r->view( 'contactTable', $d->company->getContacts());
  $html .= $r->view( 'projectTable', $d->company->getProjects());



  return  array(
    'title' => $d->company->getName(),
    'controls' => $company_selector,
    'body' => $html
	);	
}
?>