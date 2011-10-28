<?php
function noteNewForm( $n, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'Note', 'action'=>'create'));
    $fs = $form->getFieldSetFor($n);

    $list_items = array(
  		'Company'	=> $fs->company_id,
  		'Staff'	=> $fs->staff_id,
  		'Name' => $fs->name,
  		'Details' => $fs->description,
  		'Date'=> $fs->date
  	);	
    
    $form->content = $r->view( 'basicFormContents', 
    							$list_items, 
    							array( 'title'=>'Add New Note')
    						  );
    
    return $form->html;
}
