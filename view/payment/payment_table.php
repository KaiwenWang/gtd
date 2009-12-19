<?php
function paymentTable( $modelObjects, $o = array()){
	if ( !$modelObjects) return;
    $out = array();
    $out['headers'] = array('Date','Client','Amount');
    $out['rows'] =  array();
    $total_payments = 0;
    $r = getRenderer(  );
    foreach($modelObjects as $m){
        $total_payments += $m->getAmount( );
        $out['rows'][] = array( $r->link( 'Payment', array('action' => 'show', 'id' => $m->id), $m->getData('date')), 
                                $r->link( 'Company', array( 'action' => 'show', 'id'=>$m->getCompany()->id ), $m->getCompanyName() ), 
                                '$ ' . number_format( $m->getAmount(), 2) );
    }
    $r =& getRenderer();
    $html = $r->view('basicTable',$out, array( 'title' => 'Payments' ));
    $html .= '<div class="totals-data"><h3 class="basic-table-header">Total payments: $ ' . number_format( $total_payments, 2). '</h3></div>';
    return $html;
}
?>
