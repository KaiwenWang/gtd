<?php

class InvoiceController extends PageController {

  public $template = 'gtd_main_template';
  var $before_filters = array(
    'get_posted_records' => array('create', 'update', 'destroy'), 
    'get_search_criteria' => array('index')
  );

  function index($params) {
    $search_criteria = array('sort' => 'date DESC');
    if(!empty($this->search_for_invoices)) $search_criteria = array_merge($search_criteria, $this->search_for_invoices);

    $this->data->invoices = Invoice::getMany($search_criteria);

    $this->data->search_invoice= new Invoice();
    $this->data->search_invoice->set($search_criteria);

    $this->data->new_invoice = new Invoice();
    $this->data->new_stand_invoice = new Invoice();

    $this->data->new_batch = new InvoiceBatch();
    $this->data->new_batch->set(array('created_date' => Util::date_format_from_time()));
  }

  function create($params) {
    $inv = $this->new_invoices[0];
    $inv->setNewAsOutstanding();
    $inv->execute();
    $inv->save();

    $this->redirectTo(array('controller' => 'Invoice', 'action' => 'show', 'id' => $inv->id));
  }

  function show($params) {
    if(!isset($params['id'])) bail("must haz id to show you that!");
    $this->data->invoice = new Invoice($params['id']);
    $this->data->company = $this->data->invoice->getCompany();
  }

  function edit($params) {
    if(!isset($params['id'])) bail("must haz id to show you that!");
    $this->data->invoice = new Invoice($params['id']);
  }

  function email($params) {
    $i = New Invoice($params['id']);  
    $i->sendEmail();
    $this->redirectTo(array('controller' => 'Invoice', 'action' => 'index'));
  }

  function batch_email($params) {
    if(!isset($params['table-rows'])) bail("Must haz id to do that!");
    foreach ($params['table-rows'] as $id) {
      $i = new Invoice($id);
      $i->sendEmail();
    }
    $this->redirectTo(array('controller' => 'Invoice', 'action' => 'index'));
  }

  function update($params) {
    $inv = $this->updated_invoices[0];
    $inv->execute();
    $inv->save();

    $this->redirectTo(array('controller' => 'Invoice', 'action' => 'index'));
  }

  function destroy($params) {
    if(!isset($params['id'])) bail("Must haz id to do that!");
    $inv = new Invoice($params['id']);
    $inv->destroy();

    $this->redirectTo(array('controller' => 'Invoice', 'action' => 'index'));
  }

}

?>
