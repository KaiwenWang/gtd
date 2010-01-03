<?php
function paymentTable( $payments, $o = array()){
    $r = getRenderer();

	if ( !$payments) return '';

    $table = array();
    $table['headers'] = array('Date','Client','Amount');
    $table['rows'] =  array();
    $total_payments = 0;
    $r = getRenderer(  );
    foreach($payments as $m){
        $total_payments += $m->getAmount( );
        $table['rows'][] = array( $r->link( 'Payment', array('action' => 'show', 'id' => $m->id), $m->getData('date')), 
                                $r->link( 'Company', array( 'action' => 'show', 'id'=>$m->getCompany()->id ), $m->getCompanyName() ), 
                                '$ ' . number_format( $m->getAmount(), 2) );
    }

    $payment_table = $r->view('basicTable', $table, array( 'title' => 'Payments' ));

    $total_payments = $r->view('basicMessage', 'Total payments: $ '.number_format( $total_payments, 2));

    return 	$total_payments
			.$payment_table;
}
?>
