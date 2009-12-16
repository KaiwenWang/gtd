<?php
function addonTable( $modelObjects, $o = array()){
    $r =& getRenderer();
    $out = array();
    $out['headers'] = array('Date',
                            'Item Name',
                            'Company',
    						'Amount');
    $out['rows'] =  array();
    $total_addons=0;
    foreach($modelObjects as $m){
        $total_addons += $m->getData( 'amount' );
        $company = $m->getCompany(  );
        $out['rows'][] = array(	strftime( '%b %e, %Y', strtotime( $m->get( 'date' ) ) ),
                                $r->link( 'AddOn', array('action'=>'show','id'=>$m->id),$m->getName()),
                                $r->link( 'Company', array( 'action'=>'show' ,'id'=>$company->id), $company->getName( )  ),
      							'$ ' . number_format( $m->get('amount'), 2 ) );
    }

    $html = $r->view('basicTable',$out, array('title'=>'Add Ons'));
    $html .= '<div class="totals-data"><h3 class="basic-table-header">Total Addons: $ ' . number_format( $total_addons, 2). '</h3></div>';
    return $html;
}
?>
