<?php
function hourTable( $hours = array(), $o = array() ){
	$r = getRenderer();

        $table['headers'] = array(
		'Date',
		'Client',
		'Description',
		'Staff',
		'Hours',
		'Billable',
		'Type',
		'Edit',
		'Delete'
	);
	
	$table['rows'] =  array();
	
	$total_hours = 0;
	$billable_hours = 0;
  
	$hours_to_skip = array();

	foreach($hours as $h){

		if(!empty($hours_to_skip[$h->id])){
			continue;
		}

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

    $name = $h->getStaffName();
    if($h->getPairName()){
      $name.' and '.$h->getPairName();
    }

		$logged = 	$h->getHours();
		$billable	= $h->getBillableHours();
		$type = 	$h->getType();
		
		if($h->is_pair()){
			$name = $h->getPairName();
			$logged = $logged * 2;
			$billable = $billable *2;
			$hours_to_skip[$h->get('pair_hour_id')] = true;
		}

		$table['rows'][] = array(	
			$h->getData('date'),
			$company_link,
			$description,
			$name,
			$logged,
			$billable,
			$type,
			$edit_button,
			UI::button( array('controller'=>'Hour','action'=>'destroy','id'=>$h->id))
		);
  }
	
	$o['title'] = 'Hours' . ' <a class="button ui-state-default ui-corner-all"><span class="ui-icon ui-icon-triangle-1-s"></span></a>';
	$o['id'] = 'hour-table';
    
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
