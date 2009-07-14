<?php

function projectInfo( $project, $o = array()){
    $r =& getRenderer();
    $list_items = array(
    	'Company'				=> $project->getCompanyName(),
    	'Status'				=> $project->getData('status'),
    	'Project Manager'		=> $project->getStaffName(),    	
    	'Designer'				=> $project->getData('designer'),
    	'Launch Date'			=> $project->getData('launch_date'),
    	'Hour Cap'				=> $project->getData('hour_cap'),
    	'Hourly Rate'			=> $project->getData('hourly_rate'),
    	'Low Estimate'			=> $project->getLowEstimate(),
    	'High Estimate'			=> $project->getHighEstimate(),
    	'Total Hours Worked'	=> $project->getTotalHours(''),
    	'Total Billable Hours'	=> $project->getBillableHours('')
    );
    $project_info = $r->view( 'basicList', $list_items);
    
    return $project_info;
}
?>
