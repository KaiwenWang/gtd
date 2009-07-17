<?php
class SupportContractDetail extends PageController {
    function get( $x ) {
        $r =& getRenderer();
        $id = $this->params( 'id' );
        $contract = new SupportContract( $id );
        $contract_finder = $r->view( 'jumpSelect', $contract );
        $info = $r->view( 'supportContractInfo', $contract );
        $hour_table = $r->view( 'hourTable', $contract->getHours( ));
        $bandwidth_table = $r->view( 'bandwidthTable', $contract->getBandwidth( ));
        $invoices_table = $r->view( 'invoiceTable', $contract->getInvoices( ));
        $products = $contract->getProductInstances( );
        $products_list = '';
        if( $products ) {
            foreach( $products as $prod ) {
                $products_list .= $r->view( 'productInstanceInfo', $prod );
            }
        }
          
        return $r->template('template/standard_inside.html',
                            array(
                            'title' => $contract->getName(),
                            'controls' => $contract_finder,
                            'body' => $info . $hour_table . $invoices_table . $bandwidth_table . $products_list ));
    }
}


?>
