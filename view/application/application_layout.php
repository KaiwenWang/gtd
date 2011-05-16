<?php
function applicationLayout(){
	$r = getRenderer();
	$form = new Form( array(
				'controller'=>'Company',
				'action'=>'show',
				'method'=>'get',
				'auto_submit'=>array('id')
		));
	$f = $r->classSelect('Company',array('title'=>'Jump to Client','id'=>'client_quicksearch','name'=>'id'));
	$form->content = $f;
	$client_search_form = $form->html;
  $bookmark_widget = $r->view('bookmarkWidget', array());

	return array(
		'client_quicksearch'=> $client_search_form,
    'bookmark' => $bookmark_widget
		);
}
