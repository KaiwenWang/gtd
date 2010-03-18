<?php
function companyTable( $companies, $o = array()){
	if(!$companies) return;

    $r =& getRenderer();


	$form = new Form( array(
					'controller'=>'company',
					'action'=>'index',
					'method'=>'get',
					'auto_submit'=>array('country'),
					));
	$f=$form->getFieldSetFor( new Company());
	$form_content = $f->org_type;
	$form_content .= $f->country;
	$form->content = $form_content; 
 
//	$form->content = $r->classSelect( 'Company', array( 'name'=>'org_type' ));

	$search_form = $form->html;
	
    $table = array();

    $table['headers'] = array('Client','Status','Balance');

    $table['rows'] =  array();

    foreach($companies as $c){
      $link = $r->link('Company',array('action'=>'show','id'=>$c->id),$c->getName());

      $table['rows'][] = array( $link, 
								$c->getData('status'), 
								$c->getData('balance') 
								);
    }

    return $r->view( 'basicTable', $table, array('title'=>'Search Clients','search'=>$search_form));
  
}
?>
