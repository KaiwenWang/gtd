<?php
class SupportContractController extends PageController {

    function index( $params ){
        $this->data->contracts = getMany( 'SupportContract', 
        								  array("sort"=>"status, company_id")
        								);
	}
    function show( $params ) {
        $this->data->contract = new SupportContract( $params['id'] );
	}
}