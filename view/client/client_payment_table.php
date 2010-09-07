<?php
function clientPaymentTable( $payments, $o = array()){
    $r = getRenderer();

    $table = array();
    $table['headers'] = array('Invoice #','Payment Type','Deposit Date','Amount');
    $table['rows'] =  array();
    $r = getRenderer(  );
    foreach($payments as $p){
        $total_payments += $p->getAmount( );
		$table['rows'][] = array( 
								UI::link( array( 'text'=>$p->getInvoiceId(),'controller'=>'Invoice','action'=>'show','id'=>$p->getInvoiceId())),
								$p->getType(),
								$p->getData('date'), 
								'$ ' . number_format( $p->getAmount(), 2)
								);
    }

    $payment_table = $r->view('basicTable', $table, array_merge(array( 'title' => 'Payments'), $o));

	return 	'<div id="payments-table">'
			.$payment_table
			.'</div>';
}
?>
