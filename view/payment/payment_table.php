<?php
function paymentTable( $payments, $o = array()){
    $r = getRenderer();

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

    $payment_table = $r->view('basicTable', $table, array_merge(array( 'title' => 'Payments'), $o));

    $total_payments = $r->view('basicMessage', 'Total payments: $ '.number_format( $total_payments, 2));

	return 	'<div id="payments-table">'
			.$total_payments
			.$payment_table
			.'</div>';
}
?>
