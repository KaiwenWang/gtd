<?php
class CompanyController extends PageController {
  public $template = 'gtd_main_template';
  var $before_filters = array('get_posted_records' => array( 'create','update','destroy'),
                              'get_search_criteria'=> array('index','kneecaps'));

  function index( $params){
    $criteria = array();
    if( !empty($this->search_for_companies)) $criteria = $this->search_for_companies;
    $criteria['sort'] = 'status, name';

    $this->data->companies = Company::getMany($criteria);
    $this->data->new_company = new Company();
    $this->data->search_company = new Company();
    $this->data->search_company->set($criteria); 
  } 

  function show($params){
    if(empty($params['id'])) bail('no company selected');

    $this->data->company = new Company( $params['id']);
    $user_id = Session::getUserId();
    
    $p = new Project();	
    $p->set(array(
      'company_id'=>$params['id'],
      'staff_id'=>$user_id
    ));
    $this->data->new_project = $p;
	
    $this->data->new_note = new Note();
    $this->data->new_note->set(array( 
      'date' => date('Y-m-d'),
      'staff_id'=>Session::getUserId(),
      'company_id' => $params['id'] 
    ));

    $this->data->new_charge = new Charge();
    $this->data->new_charge->set(array( 
      'date' => date('Y-m-d'),
      'company_id' => $params['id'] 
    ));

    $this->data->new_payment = new Payment();
    $this->data->new_payment->set(array( 
      'date' => date('Y-m-d'),
      'company_id' => $params['id'] 
    ));

    $this->data->new_invoice = new Invoice();
    $this->data->new_invoice->set(array( 
      'company_id' => $params['id'] 
    ));

    $this->data->new_contact = new Contact();
    $this->data->new_contact->set(array( 
      'company_id' => $params['id'] 
    ));
  }

  function create( $params){
    $company = $this->new_companies[0];
    $company->save();

    if(!empty($this->new_contacts)){
      $contact = $this->new_contacts[0];
      $contact->set(array('company_id'=>$company->id));
      $contact->save();
    }
    $this->redirectTo( array(
      'controller'=>'Company',
      'action' => 'show',
      'id'=>$company->id
    ));
  }

  function update( $params){
    $c = $this->updated_companies[0];
    $c->save();

    Render::msg($c->getName().' Updated.');	

    $this->redirectTo( array(
      'controller'=>'Company',
      'action' => 'show',
      'id'=>$c->id
    ));
  }

  function new_form( $params){
    $this->data = new Company();
  }

  function kneecaps( $params){
    $criteria = array();
    if( !empty($this->search_for_companies)) $criteria = $this->search_for_companies;
    $criteria['sort'] = 'status, name';
    $this->data->companies = Company::getMany($criteria);

    $this->data->search_company = new Company();
    $this->data->search_company->set($criteria); 
  }

  function destroy(){
  }

}
