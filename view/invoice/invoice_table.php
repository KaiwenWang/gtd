<?php
function invoiceTable( $invoices, $options = array( )) {
    if( !$invoices ) return 'There are no invoices at this time';
    $r = getRenderer();
    $table = array();
    $table['headers'] = array(	'ID',
								'Client',
    							'Start Date',
                                'End Date',
    							'Sent Date',
    							'Amount'
    							);
    $table['rows'] =  array();
    foreach($invoices as $i){
      	$url = $i->getData('url');
		$c = $i->getCompany();
      	$table['rows'][] = array(	$i->id,
								$r->link('Company', array('action' => 'show', 'id' => $c->id), $c->getName()),
      							$r->link( 'Invoice', array('action' => 'show', 'id' => $i->id ), $i->getData( 'start_date')),
      							$i->getData('end_date'),
      							"<a href='$url' target='_blank'>" . $i->getData('sent_date') . "</a>",
      							$i->getAmountDue()
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Invoices'));
    return $html;
}
?>
