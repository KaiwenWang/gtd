<?php
class SupportHourController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );
	
    function index( $params ){
        $d = $this->data;
        $d->support_hours = getMany( 'SupportHour', array('sort' => 'id DESC'));
		$d->new_support_hour = new SupportHour();
		$d->new_support_hour->set( array( 'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
    
    }
    function show( $params ){
		if ( !$params['id']) bail('Required $params["id"] not present.');

    	$d = $this->data;

        $d->hour = new Hour( $params['id']);
	    $d->support_contract = new SupportContract( $d->hour->get('support_contract_id'));

		$d->new_hour = new Hour();
		$d->new_hour->set( array( 'support_contract_id'=>$params['id'],
								  'staff_id'=>getUser(),
								  'date'=>date('Y-m-d')
								  ));
    }
    function update( $params ){
    	$h = $this->updated_hours[0];
		$h->save();
        $this->redirectTo(array('controller' => 'SupportHour', 
        						'action' => 'show', 
        						'id' => $h->id
        						));
    }
    function new_record(){
    }
    function create( $params){
		$h = $this->new_hours[0];
		$h->save();

		isset($params['redirect']) 	? $redirect = $params['redirect']
									: $redirect = array(
													'controller'=>'SupportContract',
        											'action' => 'show', 
        											'id' => $h->get('support_contract_id')
                            						);

        $this->redirectTo($redirect);
    }
    function destroy(){
    }
}
