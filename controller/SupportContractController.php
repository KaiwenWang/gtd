<?php
class SupportContractController extends PageController {
	public $template = 'gtd_main_template';
 	var $before_filters = array( 'get_posted_records' => array('process_cancellation','process_renewal','create','update','destroy') );
    
	function index( $params ){
        $this->data->new_contract = new SupportContract();

		$this->data->contracts = getMany( 'SupportContract', 
        								  array("sort"=>"status, company_id")
        								);

		$this->data->new_hour = new Hour();
		$this->data->new_hour->set(array( 
										'staff_id' => getUser(),
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
		$this->data->new_charge = new Charge();
		$this->data->new_charge->set(array( 
										'date' => date('Y-m-d'),
									  	'company_id' => $this->data->contract->get( 'company_id' ) )
										);
        $this->data->hours = getMany('Hour', array_merge(
                    array('support_contract_id'=>$params['id'], 'sort' => 'date DESC'), $this->search_params('hour_search')));
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

	function update(){
        $contract = $this->updated_support_contracts[0];
        $contract->save();
    	$this->redirectTo( array('controller'=>'Company','action' => 'show', 'id' => $contract->get('company_id')));
    }
	function create(){
        $contract = $this->new_support_contracts[0];
        $contract->save();
    	$this->redirectTo( array('controller'=>'Company','action' => 'show', 'id' => $contract->get('company_id')));
    }
	function cancel( $params ){
		$d = $this->data;
		$params['id']	? $d->contract = new SupportContract( $params['id'] )
						: Bail('required parameter $params["id"] missing.');

		if( $d->contract->get('end_date') == EMPTY_DATE_STRING ){
			$d->contract->set( array( 
								'end_date' 	=> date('Y-m-d') 
								));
			$d->set_end_date_to_todays_date = true;
		}
	}
	function new_form(){
        $this->data= new SupportContract();
	}
	function process_cancellation(){
		$contract = $this->updated_support_contracts[0];
		$contract->set(array(
							'status'=>SUPPORT_CONTRACT_STATUS_CANCELLED
						));
		$contract->save();
        $this->redirectTo(array('controller' => 'Company', 
        						'action' => 'show', 
        						'id' => $contract->get('company_id')
        						));

	}
	function correct_mistake( $params ){
		$d = $this->data;
		$params['id']	? $d->contract = new SupportContract( $params['id'] )
						: Bail('required parameter $params["id"] missing.');
	}
}

