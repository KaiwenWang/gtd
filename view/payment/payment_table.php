<?php
function paymentTable( $payments, $o = array()){
    $r = getRenderer();

	// CREATE SEARCH FORM
	$search_form = '';
	if( !empty($o['search_payment']) && is_a( $o['search_payment'], 'Payment')){
		$form = new Form( array(
						'controller'=>'payment',
						'action'=>'index',
						'method'=>'get',
						'auto_submit'=>array('payment_type','company_id')
						));

		$form->content = $form->getFieldSetFor( $o['search_payment'] )->field('payment_type',array('title'=>'Payment Type'));
		$form->content .= $form->getFieldSetFor( $o['search_payment'] )->field('company_id',array('title'=>'Client'));
		$search_form = $form->html;
	}

    $table = array();
    $table['headers'] = array('Date','Invoice ID','Client','Amount','Type','Edit','Delete');
    $table['rows'] =  array();
    $total_payments = 0;
    $r = getRenderer(  );
    foreach($payments as $p){
        $total_payments += $p->getAmount( );
		$table['rows'][] = array( 
								UI::link( array('controller'=>'Payment','action' => 'show', 'id' => $p->id, 'text'=>$p->getData('date'))), 
								UI::link( array( 'text'=>$p->getInvoiceId(),'controller'=>'Invoice','action'=>'show','id'=>$p->getInvoiceId())),
                                UI::link( array( 'controller'=>'Company','action' => 'show', 'id'=>$p->getCompany()->id, 'text'=>$p->getCompanyName())), 
								'$ ' . number_format( $p->getAmount(), 2),
								$p->getType(),
								UI::button(array('controller'=>'Payment','action'=>'show','id'=>$p->id)),
								UI::button(array('controller'=>'Payment','action'=>'destroy','id'=>$p->id)),
								);
    }

    $payment_table = $r->view('basicTable', $table, array( 'title' => 'Payments', 'search' => $search_form));

    $total_payments = $r->view('basicMessage', 'Total payments: $ '.number_format( $total_payments, 2));

    return 	$total_payments
			.$payment_table;
}
?>
