<?php
function projectInfo( $p, $o = array()){
    $r =& getRenderer();
    return '
    	<div class="basic-list" style="width:80%;">
    		<div>
    			<span>
    				Company: '.$r->link( 'CompanyDetail', array('id'=>$p->get('company_id')), $p->getCompanyName()).'
    	   		</span>
    			<span style="float:right">Launch Date: '.$p->get('launch_date').'</span>
    		</div>
    		<div>
    			<span>Project Manager: '.$r->link( 'StaffDetail', 
    	   								 array('id'=>$p->get('staff_id')),
    	   								 $p->getStaffName()).'
		    	Designer: '.$p->get('designer').'
    	   		</span>
    			<span style="float:right">Status: '.$p->get('status').'</span>
			</div>
			<div>
		    	Hour Cap: '.$p->get('hour_cap').'
		    	Hourly Rate: '.$p->get('hourly_rate').'
		    	Low Estimate: '.$p->getLowEstimate().'
		    	High Estimate: '.$p->getHighEstimate().'
		    	Total Hours Worked: '.$p->getTotalHours().'
		    	Total Billable Hours: '.$p->getBillableHours().'
			</div>
    	</div>
    ';
}
/*
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
	return $r->view( 'basicList', $list_items, $o);
}
*/
?>
