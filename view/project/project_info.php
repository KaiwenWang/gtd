<?php
function projectInfo( $p, $o = array()){
    $r =& getRenderer();
    $p->get('launch_date') ? $launch_date = date( 'm/d/Y',
    											strtotime($p->get('launch_date'))
    											)
    					   : $launch_date = 'NOT SET';
    $html = '
    		<div>
    			Project: '.$p->get('name').'
    		</div>
    		<div>
    			Company: '.$r->link( 'Company', array('action'=>'show','id'=>$p->get('company_id')), $p->getCompanyName()).'
    		</div>
    		<div>
				<span class="launch-date">Launch Date: '.$launch_date.'</span>    		
				<span class="status-label">
					Status: 
				</span>				
				<span class="status">
				'.$p->get('status').'
				</span>
			</div>
    		<div>
    			<span class="project-manager-label">
	    			Project Manager: 
    			</span>
    			<span class="project-manager">
    					'.$r->link( 	'Staff', 
	    			   								 array('action'=>'show','id'=>$p->get('staff_id')),
    			   									 $p->getStaffName()).'
				</span>
			</div>';
	if( $p->get('designer') ){
		$html .='
			<div>
		    	Designer: '.$p->get('designer').'
			</div>
			';
	}
	$html .='
			<div class="detail-project-hours">
		    	<span class="float-left">Low Estimate: '.$p->getLowEstimate().'</span>			
		    	<span class="float-left">Hour Cap: '.$p->get('hour_cap').'</span>
		    	<span class="float-left">High Estimate: '.$p->getHighEstimate().'</span>		    	
		    	<span class="float-left">Hourly Rate: '.$p->get('hourly_rate').'</span>
		    	<span class="float-left">Total Hours Worked: '.$p->getTotalHours().'</span>
		    	<span class="float-left">Total Billable Hours: '.$p->getBillableHours().'</span>
		    	<div class="clear-left"></div>
			</div>
    ';
    return $html;
}
?>
