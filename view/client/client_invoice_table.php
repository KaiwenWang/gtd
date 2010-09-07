<?php
function clientInvoiceTable( $invoices, $o = array( )) {
    $r = getRenderer();

	// CREATE SEARCH FORM
	$search_form = '';
	$form = new Form(
				array( 
					'controller'=>'Invoice',
					'action'=>'show',
					'method'=>'get'
					)
		);
	$form->content = '
			<div>
			<label>Invoice #</label>
			<input type="text" name="id">
			'.$form->getSubmitBtn().'
			</div>
			';
		$search_form .= $form->html;

	if( !empty($o['search_invoice']) && is_a( $o['search_invoice'], 'Invoice')){
		$form = new Form( array(
						'controller'=>'Invoice',
						'action'=>'index',
						'method'=>'get',
						'id'=>'invoice-search',
						'auto_submit'=>array('company_id')
						));
		
		$fs = $form->getFieldSetFor( $o['search_invoice'] );
		$form->content = $fs->field('company_id',array('title'=>'Client'));
		$form->content .= ' <label>Amount</label> ';
		$form->content .= $fs->field('amount_due',array('title'=>'Amount'));
		$form->content .= ' <label>Sent Date</label> ';
		$form->content .= $fs->field('sent_date',array('title'=>'Sent Date'));
		$form->content .= $form->getSubmitBtn();
		$search_form .= $form->html;

	}

    $table = array();
    $table['headers'] = array(	
								'Invoice #',
    							'Start Date',
                                'End Date',
								'Email',
    							'Sent Date',
    							'Amount'
    							);
    $table['rows'] =  array();

    foreach($invoices as $i){
      	$url = $i->getData('url');
		$c = $i->getCompany();
		if ($i->getData('type') == 'dated'){
			$invoice_date = $i->getData('end_date');
		} else {
			$invoice_date = $i->getData('date');
		}
		$email_button= UI::button( array(	'controller'=>'Invoice',
											'action'=>'email',
											'id'=>$i->id
											));
      	
      	$table['rows'][] = array(	
								$i->id,
      							$r->link( 'Invoice', array('action' => 'show', 'id' => $i->id ), $invoice_date),
      							$i->getData('end_date'),
								$email_button,
      							"<a href='$url' target='_blank'>" . $i->getData('sent_date') . "</a>",
								"<span>$</span>" . $i->getAmountDue()
							);
	}

    $table = $r->view( 'basicTable', $table, array('title'=>'Invoices','search'=>$search_form));
	$form = new Form(array('controller'=>'Invoice','action'=>'batch_email', 'disable_submit_btn'=>true));
	$form->content = $table;
    return  $form->html;
}
?>
