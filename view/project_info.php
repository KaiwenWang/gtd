<?php

function projectInfo( $p, $o = array()){
    $r =& getRenderer();
    $list_items = array(
    	'Company'				=> $r->link( 'CompanyDetail', 
    										 array('id'=>$p->get('company_id')), 
    										 $p->getCompanyName()),
    	'Status'				=> $p->get('status'),
    	'Project Manager'		=> $r->link( 'StaffDetail', 
    										 array('id'=>$p->get('staff_id')), 
    										 $p->getStaffName()),    	
    	'Designer'				=> $p->get('designer'),
    	'Launch Date'			=> $p->get('launch_date'),
    	'Hour Cap'				=> $p->get('hour_cap'),
    	'Hourly Rate'			=> $p->get('hourly_rate'),
    	'Low Estimate'			=> $p->getLowEstimate(),
    	'High Estimate'			=> $p->getHighEstimate(),
    	'Total Hours Worked'	=> $p->getTotalHours(),
    	'Total Billable Hours'	=> $p->getBillableHours()
    );
	return $r->view( 'basicList', $list_items);
}
?>
