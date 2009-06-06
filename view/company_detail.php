<?php
/**
  	companyDetail
    
    View that displays details on a company
                 
    @return html
    @package view

*/

function companyDetail( $company, $o){
	$html = '';

	$html .= '<h2>Details for '.$company->getName().'</h2>';
	$html .= '<div>Status: '.$company->getData('status').'</div>';
	$html .= '<div>Balance: '.$company->getBalance().'</div>';

	$html .= '<h3>Contacts </h3>';
    $r = getRenderer();
	$contacts = $company->getContacts();
	$html .= $r->view( 'contactTable', $contacts);

	$html .= '<h3>Projects </h3>';	
	$projects = $company->getProjects();
	$html .= $r->view( 'projectTable', $projects);

	$html .= '<h3>Payments</h3>';	
	$payment = $company->getPayments();
	$html .= $r->view( 'paymentTable', $payment);
	
	return $html;
	
}
?>