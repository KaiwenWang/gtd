<?php

function estimateInfo( $estimate, $o = array()){
    $r =& getRenderer();
    $list_items = array(
    	'Estimate'				=> $estimate->getName(),
    	'Due Date'				=> $estimate->getData('due_date'),
    	'High Estimate'		=> $estimate->getHighEstimate(),    	
        'Low Estimate'		=> $estimate->getLowEstimate( ),
        'Total Hours'		=> $estimate->getTotalHours( ),
        'Billable Hours'	=> $estimate->getBillableHours( ),
    	'Completed'			=> $estimate->getData('completed') ? 'yes' : 'no',
    	'Notes'				=> $estimate->getData('notes')
    );
	return $r->view( 'basicList', $list_items, $o);  
}
?>
