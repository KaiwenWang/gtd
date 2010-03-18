<?php
class CompanyController extends PageController {
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy'),
								 'get_search_criteria'=>array('index')
 								);
    function index( $params){
		$criteria = array();
		if( !empty($this->search_for_companies)) $criteria = $this->search_for_companies;
		$criteria['sort'] = 'status, name';

        $this->data->companies = Company::getMany($criteria);

        $this->data->new_company = new Company();
        
    }        
	function show($params){
		$params['id']	? $this->data->company = new Company( $params['id'])
						: bail('no company selected');

    	$p = new Project();
		$user_id = getUser();	
		$p->set( array(	'company_id'=>$params['id'],
						'staff_id'=>$user_id
					  ));
		$this->data->new_project = $p;

		$this->data->new_charge = new Charge();
		$this->data->new_charge->set(array( 
										'date' => date('Y-m-d'),
									  	'company_id' => $params['id'] ));

		$this->data->new_payment = new Payment();
		$this->data->new_payment->set(array( 
										'date' => date('Y-m-d'),
									  	'company_id' => $params['id'] ));

		$this->data->new_invoice = new Invoice();
		$this->data->new_invoice->set(array( 
									  	'company_id' => $params['id'] ));

		$this->data->new_contact = new Contact();
		$this->data->new_contact->set(array( 
									  	'company_id' => $params['id'] ));
  	}
	function create( $params){
		$c = $this->new_companies[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company',
    							 'action' => 'show',
    							 'id'=>$c->id
    							 ));
    }
	function update( $params){
		$c = $this->updated_companies[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company',
    							 'action' => 'show',
    							 'id'=>$c->id
    							 ));
    }
    function new_record(){
    }
    function destroy(){
    }

}
