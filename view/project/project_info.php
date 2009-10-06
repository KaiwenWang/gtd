<?php
function projectInfo( $p, $o = array()){
    $r =& getRenderer();
    return '
    	<div class="detail-list">
    		<div>
    			<span>
    				Company: '.$r->link( 'Company', array('action'=>'show','id'=>$p->get('company_id')), $p->getCompanyName()).'
    	   		</span>
    			<span style="float:right">Launch Date: '.$p->get('launch_date').'</span>
    		</div>
    		<div>
    			<span>Project Manager: '.$r->link( 	'Staff', 
	    			   								 array('action'=>'show','id'=>$p->get('staff_id')),
    			   									 $p->getStaffName()).'
		    	Designer: '.$p->get('designer').'
    	   		</span>
    			<span style="float:right">Status: '.$p->get('status').'</span>
			</div>
			<div class="detail-project-hours">
		    	<span>Hour Cap: '.$p->get('hour_cap').'</span>
		    	<span>Hourly Rate: '.$p->get('hourly_rate').'</span>
		    	<span>Low Estimate: '.$p->getLowEstimate().'</span>
		    	<span>High Estimate: '.$p->getHighEstimate().'</span>
		    	<span>Total Hours Worked: '.$p->getTotalHours().'</span>
		    	<span>Total Billable Hours: '.$p->getBillableHours().'</span>
			</div>
    	</div>
    ';
}
?>
