<?php
/**
  	companyDetail
    
    View that displays details on a company
                 
    @return html
    @package view

*/

function companyInfo( $company, $o){
    $r =& getRenderer();

	$list_items = array(
					'Status'	=> $company->getData('status'),
					'Balance'	=> $company->getBalance()
					);
					
	$html = $r->view( 'basicList', $list_items);
	
	return $html;
	
}
?>