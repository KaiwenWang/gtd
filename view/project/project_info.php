<?php
function projectInfo( $p, $o = array()){
    $r =& getRenderer();
    $html = '
    	<div class="detail-list">
    		<div class="float-right">
				<span>Status: '.$p->get('status').'</span>
				<br>
				<span>Launch Date: '.$p->get('launch_date').'</span>
			</div>
    		<div>
    				Company: '.$r->link( 'Company', array('action'=>'show','id'=>$p->get('company_id')), $p->getCompanyName()).'
    		</div>
    		<div>
    			Project Manager: '.$r->link( 	'Staff', 
	    			   								 array('action'=>'show','id'=>$p->get('staff_id')),
    			   									 $p->getStaffName()).'
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
		    	<span>Hour Cap: '.$p->get('hour_cap').'</span>
		    	<span>Hourly Rate: '.$p->get('hourly_rate').'</span>
		    	<span>Low Estimate: '.$p->getLowEstimate().'</span>
		    	<span>High Estimate: '.$p->getHighEstimate().'</span>
		    	<span>Total Hours Worked: '.$p->getTotalHours().'</span>
		    	<span>Total Billable Hours: '.$p->getBillableHours().'</span>
			</div>
    	</div>
    ';
    return $html;
}
?>
