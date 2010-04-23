<?php
function hourTable( $hours, $o = array() ){
    $r = getRenderer();
    if(!$hours) return false;

    $table['headers'] = array('Date','Client', 'Description','Staff','Hours','Billable','Type','Edit','Delete');
    $table['rows'] =  array();
    
    $total_hours = 0;
    $billable_hours = 0;
    
	foreach($hours as $h){
		$total_hours += $h->getHours();
		$billable_hours += $h->getBillableHours();

		if( $h->is_project_hour()){
			$description = UI::link( array( 'controller'=>'Hour', 'action'=>'show','id'=>$h->id, 'text'=>$h->getName()));
			$edit_button = UI::button( array( 'controller'=>'Hour', 'action'=>'show','id'=>$h->id));
		} else {
			$description = UI::link( array( 'controller'=>'SupportHour', 'action'=>'show','id'=>$h->id, 'text'=>$h->getName()));
			$edit_button = UI::button( array( 'controller'=>'SupportHour', 'action'=>'show','id'=>$h->id));
		}

		$company_link = UI::link(array('text'=>$h->getCompanyName(),'controller'=>'Company','action'=>'show','id'=>$h->getCompany()->id));

		$table['rows'][] = array(	
							$h->getData('date'),
							$company_link,
							$description,
							$h->getStaffName(),
						    $h->getHours(),
						    $h->getBillableHours(),
							$h->getType(),
							$edit_button,
							UI::button( array('controller'=>'Hour','action'=>'destroy','id'=>$h->id))
							);
    }
	
	$o['title'] = 'Hours';
	$o['id'] = 'hour_table';
    
    $hours_table = $r->view( 'basicTable', $table, $o); 
    
	$totals = '
				<div class="totals-data totals-hours">
					<h3 class="basic-table-header">Total Project Hours: ' . $total_hours . '</h3>
				</div>
        		<div class="totals-data totals-hours">
					<h3 class="basic-table-header">Billable Project Hours: ' . $billable_hours . '</h3>
				</div>
				';

	return	$totals
			.$hours_table;
}
