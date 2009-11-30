<?php

class SupportContractController extends PageController {

    function index( $params ){
        $this->data->new_contract = new SupportContract();

		$this->data->contracts = getMany( 'SupportContract', 
        								  array("sort"=>"status, company_id")
        								);

		$this->data->new_hour = new Hour();
		$this->data->new_hour->set(array( 'staff_id' => getUser()));
	}
    function show( $params ) {
        $params['id']	? $this->data->contract = new SupportContract( $params['id'] )
						: Bail('required parameter $params["id"] missing.');
		
		$this->data->hour = new Hour();
		$this->data->hour->set(array( 'staff_id' => getUser(),
									  'support_contract_id' => $params['id'] ));
	}
}
