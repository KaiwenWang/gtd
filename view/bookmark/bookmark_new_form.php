<?php
function bookmarkNewForm($d, $o = array()){
	$r =& getRenderer();
	$form = new Form( array( 'controller'=>'Bookmark', 'action'=>'create'));
	$fs = $form->getFieldSetFor($d->bookmark);

	$list_items = array(
		'Staff' => $fs->staff_id,
		'Source' => $fs->source,
		'Description' => $fs->description
	);

	$form->content = $r->view( 'basicFormContents',
		$list_items,
		array('title'=>'Bookmark This Page')
	);
	return $form->html;
}
