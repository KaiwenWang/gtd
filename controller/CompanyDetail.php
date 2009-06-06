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

    function CompanyDetail() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();
		if( !$get['company_id']) {
			$r->msg('bad','can has company id? kthx');
			return;
		}
        $company = new Company($get['company_id']);
        $html = $r->view('companyDetail', $company);
          
        return $html;
    }        
}
?>
