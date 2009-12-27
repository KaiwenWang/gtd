<?php
function chargeTable( $charges, $o = array()){
	if(!$charges) return '<div class="clear-left"><h3>There are no charges at this time.</h3></div>';

    $r =& getRenderer();
    $out = array();
    $out['headers'] = array('Date',
                            'Item Name',
                            'Company',
    						'Amount');
    $out['rows'] =  array();
    $total_charges=0;
    foreach($charges as $m){
        $total_charges += $m->getData( 'amount' );
        $company = $m->getCompany(  );
        $out['rows'][] = array(	strftime( '%b %e, %Y', strtotime( $m->get( 'date' ) ) ),
                                $r->link( 'charge', array('action'=>'show','id'=>$m->id),$m->getName()),
                                $r->link( 'Company', array( 'action'=>'show' ,'id'=>$company->id), $company->getName( )  ),
      							'$ ' . number_format( $m->get('amount'), 2 ) );
    }

    $html = $r->view('basicTable',$out, array_merge(array('title'=>'Charges'), $o));
    $html .= '<div class="totals-data"><h3 class="basic-table-header">Total charges: $ ' . number_format( $total_charges, 2). '</h3></div><p>&nbsp;</p>';
    return $html;
}
?>
