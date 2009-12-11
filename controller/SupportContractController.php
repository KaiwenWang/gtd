<?php

class SupportContractController extends PageController {

    function index( $params ){
        $this->data->new_contract = new SupportContract();

		$this->data->contracts = getMany( 'SupportContract', 
        								  array("sort"=>"status, company_id")
        								);

		$this->data->new_hour = new Hour();
		$this->data->new_hour->set(array( 
										'staff_id' => getUser(),
										'date' => date('Y-m-d'),
										'date' => date('Y-m-d')
										));
	}
    function show( $params ) {
        $params['id']	? $this->data->contract = new SupportContract( $params['id'] )
						: Bail('required parameter $params["id"] missing.');
		
        $this->data->new_contract = new SupportContract();
		
		$this->data->new_hour = new Hour();
		$this->data->new_hour->set(array( 
										'staff_id' => getUser(),
										'date' => date('Y-m-d'),
									  	'support_contract_id' => $params['id'] )
										);
	}
}
