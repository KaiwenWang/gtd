<?php
/**
  	CompanyDetail
    
    Displays details about a particular company
   
   $params options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package controller

*/


class CompanyDetail extends PageController {
    var $_class_name = 'CompanyDetail';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();

		if( !$params['id']) bail('no company selected');

		$company = new Company( $params['id']);

		$company_selector = $r->view( 'jumpSelect', $company );
    	
        $html = $r->view( 'companyInfo', $company);
       	$html .= $r->view( 'contactTable', $company->getContacts());
		$html .= $r->view( 'projectTable', $company->getProjects());
		$html .= $r->view( 'paymentTable', $company->getPayments());

        return $r->template('template/standard_inside.html',
                            array(
                            'title' => $company->getName(),
                            'controls' => $company_selector,
                            'body' => $html
                            ));
    }        
}
?>
