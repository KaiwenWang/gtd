<?php

/**
	noteTable	
    
    View that displays a list of all Notes 
              
    @return html
    @package controller

*/

function noteTable( $notes, $o = array()){
	if( !$notes) return '';
    $r =& getRenderer();
    $table = array();
	$table['headers'] = array( 'Date',
								'Brief Description',
								'Details',
								'Company',
								'Staff',
								'Edit',
								'Delete');
    $table['rows'] =  array();
    foreach($notes as $note){
		$company = $note->getCompany();
		$edit_button = UI::button( array( 'controller'=>'Note', 'action'=>'show','id'=>$note->id));
		$delete_button = UI::button( array( 'controller'=>'Note', 'action'=>'destroy','id'=>$note->id));


		$table['rows'][] = array(   $note->getData('date'), $r->link( 'Note', array( 'action'=>'show', 'id'=>$note->id), $note->getName()),
									$r->link( 'Note', array( 'action'=>'show', 'id'=>$note->id), $note->getDescription()),
									$r->link( 'Company', array( 'action'=>'show', 'id'=>$company->id), $company->getName()),
									$note->getStaff()->getName(),
								    $edit_button, $delete_button
      						);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Notes'));
    return $html;
}
?>
