<?php
function invoiceTable( $invoices, $options = array( )) {
    if( !$invoices ) return 'There are no invoices at this time';
    $r = getRenderer();
    $table = array();
    $table['headers'] = array(	
								'ID',
								'Client',
    							'Start Date',
                                'End Date',
                                'Batch',
    							'Sent Date',
    							'Amount',
								'Edit',
								'Delete'
    							);
    $table['rows'] =  array();
    foreach($invoices as $i){
      	$url = $i->getData('url');
		$c = $i->getCompany();
		if(	$batch = $i->getBatch()){
			$batch_link = $r->link('InvoiceBatch',array('action'=>'show','id'=>$batch->id),$batch->getName());
		} else {
			$batch_link = '';
		}
		
		$edit_button = UI::button( array(	'controller'=>'Invoice',
											'action'=>'edit',
											'id'=>$i->id
											));
		$delete_button = UI::button( array(	'controller'=>'Invoice',
											'action'=>'destroy',
											'id'=>$i->id
											));
      	$table['rows'][] = array(	
								$i->id,
								$r->link('Company', array('action' => 'show', 'id' => $c->id), $c->getName()),
      							$r->link( 'Invoice', array('action' => 'show', 'id' => $i->id ), $i->getData( 'start_date')),
      							$i->getData('end_date'),
								$batch_link,
      							"<a href='$url' target='_blank'>" . $i->getData('sent_date') . "</a>",
      							$i->getAmountDue(),
								$edit_button,
								$delete_button
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Invoices'));
    return $html;
}
?>
