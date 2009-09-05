<?php
function projectInfo( $p, $o = array()){
    $r =& getRenderer();
    return '
    	<div class="basic-list">
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
?>
