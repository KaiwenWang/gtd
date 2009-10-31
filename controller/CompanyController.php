<?php
class CompanyController extends PageController {

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
	//added by margot -- get code review from ted and get it to show the new Company on redirect?
	function create( $params){
    	$c = new Company();
    	$data = $params['ActiveRecord']['Company']['new'];
    	$c->mergeData( $data);
    	$c->save();
    	$this->redirectTo( array('controller'=>'Company','action' => 'show'));
    }
    function new_record(){
    }
    function destroy(){
    }

}
?>
