<?php
function companyTable( $companies, $o = array()){

    $r = getRenderer();

	$search_form = '';
	if( !empty($o['search_company']) && is_a( $o['search_company'], 'Company')){
		$form = new Form( array(
						'controller'=>'Company',
						'action'=>'index',
						'method'=>'get',
						'auto_submit'=>array('org_type','country','status'),
						));
		$f=$form->getFieldSetFor( $o['search_company']);
		$form_content = $f->field('org_type',array('title'=>'Organization Type'));
		$form_content .= $f->field('country',array('title'=>'Country'));
		$form_content .= $f->field('status',array('title'=>'Status'));
		$form->content = $form_content; 
		$search_form = $form->html;
	}
	
    $table = array();

    $table['headers'] = array('Client','Primary Contact','Status','Last Payment','Balance');

    $table['rows'] =  array();

    foreach($companies as $c){
      $link = $r->link('Company',array('action'=>'show','id'=>$c->id),$c->getName());
      $contact_link = $r->link('Contact',array('action'=>'show','id'=>$c->getPrimaryContact()->id),$c->getPrimaryContactName());

	  $table['rows'][] = array( $link, 
								$contact_link,
								$c->get('status'), 
								$c->getLastPaymentDate(), 
								$c->calculateBalance(array('end_date'=>Util::date_format_from_time())) 
								);
    }

    return $r->view( 'basicTable', $table, array('title'=>'Search Clients','search'=>$search_form));
  
}
