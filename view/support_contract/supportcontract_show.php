<?php
function supportcontractShow($d){
        $r =& getRenderer();
        $contract_finder 	= $r->view( 'jumpSelect', 		$d->contract );
        $info 				= $r->view( 'supportContractInfo', $d->contract );
        $hour_table 		= $r->view( 'hourTable', 		$d->contract->getHours( ));
        $bandwidth_table 	= $r->view( 'bandwidthTable', 	$d->contract->getBandwidth( ));
        $invoices_table 	= $r->view( 'invoiceTable', 	$d->contract->getInvoices( ));

        $products 			= $d->contract->getProductInstances( );

        $products_list 		= '';
        if( $products ) foreach( $products as $prod ) $products_list .= $r->view( 'productInstanceInfo', $prod );


		return array(
			'title' => $d->	contract->getName(),
			'controls' => $contract_finder,
			'body' 	=> 	$info
						.$hour_table
						.$invoices_table
						.$bandwidth_table
						.$products_list
			);
}
?>