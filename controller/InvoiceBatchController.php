<?php

class InvoiceBatchController extends PageController {

  public $template = 'gtd_main_template';
  var $before_filters = array('get_posted_records' => array('create', 'update', 'destroy'));

  function show($params) {
    if(!isset($params['id'])) bail("id is a required param.");

    $this->data->batch = new InvoiceBatch($params['id']);
    $this->data->invoices = $this->data->batch->getInvoices();
  }

  function create($params) {
    $batch = $this->new_invoice_batchs[0];
    $batch->save();

    $clients = Company::getMany(array('status' => 'active'));
    foreach($clients as $c) {
      Invoice::createFromCompany($c, $batch);
    }

    $this->redirectTo(array('controller' => 'Invoice', 'action' => 'index'));
  }

}

?>
