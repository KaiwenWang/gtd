<?php
class InvoiceController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );

    function index($params) {
		$this->data->new_invoice = new Invoice();
		$this->data->new_stand_invoice = new Invoice();
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
    function email($params) {
        if(!isset($params['id'])) bail("must haz id to show you that!");
        $invoice = new Invoice($params['id']);

        $this->data->invoice = $invoice;
		$this->data->company = $invoice->getCompany();

		$r = getRenderer();
		$content = $r->view('invoiceEmail', $this->data);

		$email_address = $invoice->getBillingEmailAddress();
		$subject = 'Radical Designs Invoice ' . Util::pretty_date($invoice->get('end_date')); 

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . BILLING_EMAIL_ADDRESS."\r\n";

		$email_sent = mail($email_address,$subject,$content, $headers);

		if( $email_sent ){
			$invoice->set(array('sent_date'=>Util::date_format(),'status'=>'sent'));
			Render::msg('Email Sent');
		} else {
			$invoice->set(array('status'=>'failed'));
			Render::msg('Email Failed To Send','bad');
		}

		$invoice->save();

		$this->redirectTo(array('controller'=>'Invoice','action'=>'index'));
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
