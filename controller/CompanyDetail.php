<?php
/**
  	CompanyDetail
    
    Displays details about a particular company
   
   $get options array:
    -<b>contact_id</b> id of the contact that we want to see details for
              
    @return html
    @package controller

*/


class CompanyDetail extends PageController {
    var $_class_name = 'CompanyDetail';

    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();

		if( !$get['company_id']) {
			$r->msg('bad','can pick a company? kthx');
			$form_contents = $r->classSelect( 'Company', array('name'=>'company_id'));
			$form_contents .= $r->submit();
			$html = $r->form('get','CompanyDetail',$form_contents);
			return $html;
		}

		$company = new Company($get['company_id']);

		$form_contents = $r->objectSelect( $company, array('name'=>'company_id'));
    	$form_contents .= $r->submit();
    	$html = $r->form('get','CompanyDetail',$form_contents);
        $html .= $r->view('companyDetail', $company);

        return $html;
    }        
}
?>
