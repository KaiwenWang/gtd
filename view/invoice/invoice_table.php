<?php
function invoiceTable( $invoices, $o = array( )) {
    $r = getRenderer();

	// CREATE SEARCH FORM
	$search_form = '';
	if( !empty($o['search_invoice']) && is_a( $o['search_invoice'], 'Invoice')){
		$form = new Form( array(
						'controller'=>'Invoice',
						'action'=>'index',
						'method'=>'get',
						'auto_submit'=>array('company_id')
						));

		$fs = $form->getFieldSetFor( $o['search_invoice'] );
		$form->content = $fs->field('company_id',array('title'=>'Client'));
		$search_form = $form->html;
	}

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
		
		if ($i->getData('type') == 'dated'){
			$invoice_date = $i->getData('end_date');
		} else {
			$invoice_date = $i->getData('date');
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
								"<input class=\"check-row\" type=\"checkbox\" id=\"row-".$i->id."\" name=\"table-rows[".$i->id."]\" value=\"".$i->id."\">",
								$r->link('Company', array('action' => 'show', 'id' => $c->id), $c->getName()),
      							$r->link( 'Invoice', array('action' => 'show', 'id' => $i->id ), $invoice_date),
      							$i->getData('end_date'),
								$batch_link,
								$email_button,
      							"<a href='$url' target='_blank'>" . $i->getData('sent_date') . "</a>",
      							$i->getAmountDue(),
								$edit_button,
								$delete_button
      							);
	}

    $bulk_email_btn = '<input type="submit" value="send bulk email" style="display:inline" />';
	$select_all_box = '<input class="check-all" name="check-all" type="checkbox"/> Select All '.$bulk_email_btn;
    $table = $r->view( 'basicTable', $table, array('title'=>'Invoices','search'=>$select_all_box . $search_form));
	$form = new Form(array('controller'=>'Invoice','action'=>'batch_email', 'disable_submit_btn'=>true));
	$form->content = $table;
    return $form->html;
}
?>
