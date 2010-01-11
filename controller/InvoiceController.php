<?php
class InvoiceController extends PageController {
 	var $before_filters = array( 'get_posted_records' => array('create','update','destroy') );

    function create( $params ) {
        $inv = $this->new_invoices[0];
        $inv->execute();
        $inv->save();

        $this->redirectTo( array( 'controller' => 'Invoice', 'action' => 'show', 'id' => $inv->id ));
    }

    function show($params) {
        if(!isset($params['id'])) bail("must haz id to show you that!");
        $inv = new Invoice($params['id']);
        $this->data->invoice = $inv;
        $this->data->company = $inv->getCompany();
        $this->data->charges = $inv->getCharges();
        $this->data->project_hours = $inv->getProjectHours();
        $this->data->support_hours = $inv->getSupportHours();
    }

}
