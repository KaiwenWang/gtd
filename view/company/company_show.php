<?php
function companyShow($d){
        $r =& getRenderer();

		$company_selector = $r->view( 'jumpSelect', $d->company );
    	
        $html = $r->view( 'companyInfo', $d->company);
       	$html .= $r->view( 'contactTable', $d->company->getContacts());
		$html .= $r->view( 'projectTable', $d->company->getProjects());
		$html .= $r->view( 'paymentTable', $d->company->getPayments());

        return 			array(
                            'title' => $d->company->getName(),
                            'controls' => $company_selector,
                            'body' => $html
                        	);	
}
?>