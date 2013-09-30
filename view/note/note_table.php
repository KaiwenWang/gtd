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
								'Name',
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
    $html = $r->view( 'basicTable', $table, array('title'=>'Notes  <a class="btn ui-state-default ui-corner-all"><span class="ui-icon ui-icon-triangle-1-s"></span></a>','id'=>'note-table', 'pager' => true));
    return $html;
}
?>
