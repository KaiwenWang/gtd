<?php
class CompanyController extends PageController {

    function __construct(){
        parent::__construct();
    }
    function index( $params){
        $this->data->companies = getMany( 'Company', array("sort"=>"custom8,Company"));
    }        
	function show($params){
		$params['id']	? $this->data->company = new Company( $params['id'])
						: bail('no company selected');
	}
}
?>
