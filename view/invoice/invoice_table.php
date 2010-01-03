<?php
function invoiceTable( $invoices, $options = array( )) {
    if( !$invoices ) return false;
    $r = getRenderer();
    $table = array();
    $table['headers'] = array(	'ID',
    							'Start Date',
                                'End Date',
    							'Sent Date',
    							'Amount'
    							);
    $table['rows'] =  array();
    foreach($invoices as $e){
      $url = $e->getData('url');
      $table['rows'][] = array(	$e->id,
      							$r->link( 'Invoice', array('action' => 'show', 'id' => $e->id ), $e->getData( 'start_date')),
      							$e->getData('end_date'),
      							"<a href='$url' target='_blank'>" . $e->getData('sent_date') . "</a>",
      							$e->getAmount()
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Invoices'));
    return $html;
}
?>
