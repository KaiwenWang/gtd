<?php
class ChargeController extends PageController {
	public $template = 'gtd_main_template';
    var $before_filters = 
        array( 'get_posted_records' => array('create','update','destroy') );
    
	function index( $params ){
        $this->data->new_charge= new Charge();
		$this->data->new_charge->set(array( 'date' => date('Y-m-d') ));
		$this->data->charges= getMany( 'Charge', 
        								  array("sort"=>"date")
        								);

	}
    function show( $params ) {
        $params['id']	? $this->data->charge = new Charge( $params['id'] )
						: Bail('required parameter $params["id"] missing.');
        $this->data->company= new Company( $this->data->charge->get( 'company_id' ) );
        $this->data->new_charge= new Charge();
		$this->data->new_charge->set(array( 
										'date' => date('Y-m-d'),
									  	'company_id' => $this->data->company->id )
										);
	}
    
	function create( $params){
		$a = $this->new_charges[0];
    	$a->save();
    	$this->redirectTo( array('controller'=>'Charge',
    							 'action' => 'index'
    							 ));
    }
	function edit($params) {
        if(!isset($params['id'])) bail("must haz id to show you that!");
        $this->data->charge = new Charge($params['id']);
	}
    function update( $params ){
    	$a= $this->updated_charges[0];
		$a->save();
        $this->redirectTo(array('controller' => 'Charge', 
        						'action' => 'index'
        						));
    }
	function search($params) {
		$this->data = Charge::getMany( $params );
		$this->options = $params;
	}
    function destroy( $params ) {
		if(!isset($params['id'])) bail("must haz id to do that!");
		$inv = new Charge($params['id']);
		$inv->destroy();

        $this->redirectTo( array( 'controller' => 'Charge', 'action' => 'index' ));
       
    }
}
