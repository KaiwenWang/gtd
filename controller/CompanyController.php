<?php
class CompanyController extends PageController {
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy')
 								);
    function index( $params){
        
        $this->data->companies = getMany( 'Company', array("sort"=>"status, name"));
        $this->data->new_company = new Company();
        
    }        
	function show($params){
		$params['id']	? $this->data->company = new Company( $params['id'])
						: bail('no company selected');
    	$p = new Project();
		$p->set( array(	'company_id'=>$params['id'],
						'staff_id'=>getUser()
					  ));
		$this->data->new_project = $p;
  	}
	function create( $params){
		$c = $this->new_companies[0];
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
?>
