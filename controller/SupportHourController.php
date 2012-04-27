<?php
class SupportHourController extends PageController {
  public $template = 'gtd_main_template';
  var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	
  function index( $params ){
    $d = $this->data;
    $d->support_hours = getMany( 'SupportHour', array('sort' => 'date DESC'));
		$d->new_support_hour = new SupportHour();
		$d->new_support_hour->set( array( 'staff_id'=>Session::getUserId(),
																			'date'=>date('Y-m-d')
																		));
	}

  function show( $params ){
		if ( !$params['id']) bail('Required $params["id"] not present.');

  	$d = $this->data;

    $d->hour = new Hour( $params['id']);
	  $d->support_contract = new SupportContract( $d->hour->get('support_contract_id'));
		$d->support_hours = Hour::getMany(  array('support_contract_id' => $d->support_contract->id,'sort' => 'date DESC'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'support_contract_id'=>$d->support_contract->id,
															'staff_id'=>Session::getUserId(),
															'date'=>date('Y-m-d')
														));
	}

  function update( $params ){
    $h = $this->updated_hours[0];
    $h->updateOrCreateWithPair();
    $this->redirectTo(array(
      'controller' => 'SupportHour', 
      'action' => 'show', 
      'id' => $h->id
    ));
  }
	
  function new_record(){
  }

  function create( $params){
    $h = $this->new_hours[0];
    $h->updateOrCreateWithPair();
		
    isset($params['redirect'])  ? $this->redirectTo($params['redirect'])
                                : $this->redirectBack();
  }

  function destroy($params){
		if ( !$params['id']) bail('Required $params["id"] not present.');
		$h = new Hour($params['id']);
		$support_contract_id = $h->get('support_contract_id');
		$h->destroy();
	
		isset($params['redirect']) 	? $redirect = $params['redirect']
																: $redirect = array(
																		'controller'=>'SupportContract',
																		'action' => 'show', 
																		'id' => $support_contract_id
                            			);

    $this->redirectTo($redirect);
  }
}
