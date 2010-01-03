<?php
function chargeTable( $charges, $o = array()){
    $r =& getRenderer();
	
	if(!$charges) return $r->view('basicMessage','There are no charges at this time.');

    $table = array();
    $table['headers'] = array('Date',
                            'Item Name',
                            'Company',
    						'Amount');
    $table['rows'] =  array();
    $total_charges=0;
    foreach($charges as $m){
        $total_charges += $m->getData( 'amount' );
        $company = $m->getCompany(  );
        $table['rows'][] = array(	strftime( '%b %e, %Y', strtotime( $m->get( 'date' ) ) ),
                                $r->link( 'charge', array('action'=>'show','id'=>$m->id),$m->getName()),
                                $r->link( 'Company', array( 'action'=>'show' ,'id'=>$company->id), $company->getName( )  ),
      							'$ ' . number_format( $m->get('amount'), 2 ) );
    }

    $charges_table = $r->view('basicTable',$table, array_merge(array('title'=>'Charges'), $o));
    $total = $r->view('basicMessage','Total charges: $ ' . number_format( $total_charges, 2));

    return 	$total
			.$charges_table;
}
?>
