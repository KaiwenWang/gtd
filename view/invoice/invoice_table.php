<?php
function invoiceTable( $invoices, $options = array( )) {
    if( !$invoices ) return 'There are no invoices at this time';
    $r = getRenderer();
    $table = array();
    $table['headers'] = array(	
								'ID',
								'Add',
								'Client',
    							'Start Date',
                                'End Date',
                                'Batch',
								'Send',
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
		$email_button= UI::button( array(	'controller'=>'Invoice',
											'action'=>'email',
											'id'=>$i->id
											));
      	
      	$table['rows'][] = array(	
								$i->id,
								"<input type=\"checkbox\" id=\"invoice-email-".$i->id."\" name=\"invoice-email-".$i->id."\">",
								$r->link('Company', array('action' => 'show', 'id' => $c->id), $c->getName()),
      							$r->link( 'Invoice', array('action' => 'show', 'id' => $i->id ), $i->getData( 'start_date')),
      							$i->getData('end_date'),
								$batch_link,
								$email_button,
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
