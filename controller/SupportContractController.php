<?php
class SupportContractController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('proccess_renewal','create','update','destroy') );
    
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
		
		$this->data->new_hour = new Hour();
		$this->data->new_hour->set(array( 
										'staff_id' => getUser(),
										'date' => date('Y-m-d'),
									  	'support_contract_id' => $params['id'] )
										);
	}
	function renew( $params ){
        $params['id']	? $this->data->old_contract = new SupportContract( $params['id'] )
						: Bail('required parameter $params["id"] missing.');
		$this->data->new_contract = $this->data->old_contract->clone();
	}
	function process_renewal($params){
		$new_contract = $this->new_supportcontract[0];
		$new_contract->set( array( 'previous_contract_id' => $params['old_contract_id'] ));
		$new_contract->save();
		
		$old_contract = new SupportContract( $params['old_contract_id']);
		$old_contract->set(array(
							'status'=>'closed',
							'end_date'=>$new_contract->get('start_date'),
							'replacement_contract_id'=>$new_contract->id
						));

	}
}
