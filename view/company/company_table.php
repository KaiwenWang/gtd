<?php
function companyTable( $companies, $o = array()){
	if(!$companies) return;

    $r =& getRenderer();


	$form = new Form( array(
					'controller'=>'company',
					'action'=>'index',
					'method'=>'get',
					'auto_submit'=>array('org_type','country'),
					));
	$f=$form->getFieldSetFor( new Company());
	$form_content = $f->field('org_type',array('title'=>'Organization Type'));
	$form_content .= $f->field('country',array('title'=>'Country'));
	$form->content = $form_content; 
 
//	$form->content = $r->classSelect( 'Company', array( 'name'=>'org_type' ));

	$search_form = $form->html;
	
    $table = array();

    $table['headers'] = array('Client','Status','Balance');

    $table['rows'] =  array();

    foreach($companies as $c){
      $link = $r->link('Company',array('action'=>'show','id'=>$c->id),$c->getName());

      $table['rows'][] = array( $link, 
								$c->get('status'), 
								$c->calculateBalance(array('end_date'=>Util::date_format_from_time())) 
								);
    }

    return $r->view( 'basicTable', $table, array('title'=>'Search Clients','search'=>$search_form));
  
}
