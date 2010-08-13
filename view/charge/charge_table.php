<?php
function chargeTable( $charges, $o = array()){
    $r =& getRenderer();
	
    $table = array();
    $table['headers'] = array('Date',
                            'Name',
							'Type',	
                            'Company',
							'Amount',
							'Edit',
							'Delete');
    $table['rows'] =  array();
    $total_charges=0;
	foreach($charges as $m){
        $total_charges += $m->getData( 'amount' );
        $company = $m->getCompany(  );
		$edit_button = UI::button( array(	'controller'=>'Charge',
											'action'=>'edit',
											'id'=>$m->id
											));
		$delete_button = UI::button( array(	'controller'=>'Charge',
											'action'=>'destroy',
											'id'=>$m->id
											));

        $table['rows'][] = array(	$m->get( 'date' )  ,
								$m->getName(),
								$m->getType(),
                                #$r->link( 'charge', array('action'=>'show','id'=>$m->id),$m->getName()),
                                $r->link( 'Company', array( 'action'=>'show' ,'id'=>$company->id), $company->getName( )  ),
								'$ ' . number_format( $m->get('amount'), 2 ),
								$edit_button,
								$delete_button	);
    }

    $charges_table = $r->view('basicTable',$table, array_merge(array('title'=>'Charges','id'=>'charges-table'), $o));
    $total = $r->view('basicMessage','Total charges: $ ' . number_format( $total_charges, 2));

    return 	$total
			.$charges_table;
}
?>
