<?php
class SupportContractController extends PageController {

    function index( $params ){
        $this->data->contracts = getMany( 'SupportContract', array("sort"=>"custom8,Company") ); #status, company_id
	}
    function show( $params ) {
        $this->data->contract = new SupportContract( $params['id'] );
	}
}
?>
