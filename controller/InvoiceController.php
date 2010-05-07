<?php
class InvoiceController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );

    function index($params) {
		$this->data->new_invoice = new Invoice();
        $this->data->invoices = Invoice::getAll();
		$this->data->new_batch = new InvoiceBatch();
		$this->data->new_batch->set(array('created_date'=>Util::date_format_from_time()));
    }

    function create( $params ) {
        $inv = $this->new_invoices[0];
        $inv->execute();
        $inv->save();

        $this->redirectTo( array( 'controller' => 'Invoice', 'action' => 'show', 'id' => $inv->id ));
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
    function send($params) {
        if(!isset($params['id'])) bail("must haz id to show you that!");
        $this->data->invoice = new Invoice($params['id']);
	}
    function update( $params ) {
        $inv = $this->updated_invoices[0];
        $inv->execute();
        $inv->save();

        $this->redirectTo( array( 'controller' => 'Invoice', 'action' => 'show', 'id' => $inv->id ));
    }
	function destroy( $params ){
        if(!isset($params['id'])) bail("must haz id to do that!");
		$inv = new Invoice($params['id']);
		$inv->destroy();

        $this->redirectTo( array( 'controller' => 'Invoice', 'action' => 'index' ));
	}
}
