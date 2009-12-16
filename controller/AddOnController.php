<?php
class AddOnController extends PageController {
    var $before_filters = 
        array( 'get_posted_records' => array('create','update','destroy') );
    
	function index( $params ){
        $this->data->new_addon= new AddOn();
		$this->data->new_addon->set(array( 'date' => date('Y-m-d') ));
		$this->data->addons= getMany( 'AddOn', 
        								  array("sort"=>"date")
        								);

	}
    function show( $params ) {
        $params['id']	? $this->data->addon = new AddOn( $params['id'] )
						: Bail('required parameter $params["id"] missing.');
        $this->data->support_contract = new SupportContract( $this->data->addon->get( 'support_contract_id' ) );
        $this->data->new_addon= new AddOn();
		$this->data->new_addon->set(array( 
										'date' => date('Y-m-d'),
									  	'support_contract_id' => $this->data->support_contract->id )
										);
	}
    
	function create( $params){
		$a = $this->new_add_ons[0];
    	$a->save();
    	$this->redirectTo( array('controller'=>'AddOn',
    							 'action' => 'show',
    							 'id'=>$a->id
    							 ));
    }

    function update( $params ){
    	$a= $this->updated_add_ons[0];
		$a->save();
        $this->redirectTo(array('controller' => 'AddOn', 
        						'action' => 'show', 
        						'id' => $a->id
        						));
    }

    function destroy( ) {
        
    }
}
