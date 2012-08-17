<?php

/**
	paperworkTable	
    
    View that displays a list of all Paperwork 
              
    @return html
    @package controller

*/

function paperworkTable( $paperworks, $o = array()){
	if( !$paperworks) return '';
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
    foreach($paperworks as $paperwork){
		$company = $paperwork->getCompany();
		$edit_button = UI::button( array( 'controller'=>'Paperwork', 'action'=>'show','id'=>$paperwork->id));
		$delete_button = UI::button( array( 'controller'=>'Paperwork', 'action'=>'destroy','id'=>$paperwork->id));


		$table['rows'][] = array(   $paperwork->getData('date'), $r->link( 'Paperwork', array( 'action'=>'show', 'id'=>$paperwork->id), $paperwork->getName()),
									$r->link( 'Paperwork', array( 'action'=>'show', 'id'=>$paperwork->id), $paperwork->getDescription()),
									$r->link( 'Company', array( 'action'=>'show', 'id'=>$company->id), $company->getName()),
									$paperwork->getStaff()->getName(),
								    $edit_button, $delete_button
      						);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Paperwork  <a class="button ui-state-default ui-corner-all"><span class="ui-icon ui-icon-triangle-1-s"></span></a>','id'=>'paperwork-table'));
    return $html;
}
?>
