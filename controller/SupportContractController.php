<?php
class SupportContractController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('process_renewal','create','update','destroy') );
    
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
		$d = $this->data;
        $params['id']	? $d->old_contract = new SupportContract( $params['id'] )
						: Bail('required parameter $params["id"] missing.');

		$d->new_contract = $d->old_contract->cloneRecord();

		strtotime($d->old_contract->get('end_date')) > time() ? $end_date = $d->old_contract->get('end_date')
															  : $end_date = '';
		$d->new_contract->set( array( 
								'previous_contract_id' => $params['id'],
								'start_date' => date('Y-m-d'), 
								'end_date'	=> $end_date
								));
	}
	function process_renewal($params){
		$new_contract = $this->new_support_contracts[0];
		$new_contract->save();
		
		$old_contract = new SupportContract( $new_contract->get('previous_contract_id') );
		$old_contract->set(array(
							'status'=>'closed',
							'end_date'=>$new_contract->get('start_date'),
							'replacement_contract_id'=>$new_contract->id
						));
		$old_contract->save();

        $this->redirectTo(array('controller' => 'Company', 
        						'action' => 'show', 
        						'id' => $new_contract->get('company_id')
        						));
	}
}
