<?php
function hourTable( $hours, $o = array() ){
    $r = getRenderer();

    $table['headers'] = array('id','Action','Logged', 'Staff','Hours','Billable');
    $table['rows'] =  array();
    
    $total_hours = 0;
    $billable_hours = 0;
    
	foreach($hours as $h){
      $total_hours += $h->getHours();
      $billable_hours += $h->getBillableHours();

      $table['rows'][] = array(	
							$h->id,
						    $r->link( 'Hour', array('action'=>'show','id'=>$h->id),$h->getName()),
						    $h->getData('date'),
						    $h->getStaffName(),
						    $h->getHours(),
						    $h->getBillableHours()
      						);
    }
	
	$o['title'] = 'Hours';
	$o['id'] = 'hour_table';
    $hours_table = $r->view( 'basicTable', $table, $o); 
    
	$totals = '
				<div class="totals-data">
					<h3 class="basic-table-header">Total Hours: ' . $total_hours . '</h3>
				</div>
        		<div class="totals-data">
					<h3 class="basic-table-header">Billable Hours: ' . $billable_hours . '</h3>
				</div>
				';

    $hours_table = $r->view( 'basicTable', $table, array( 'title'=>'Hours', 'search' => $r->view('hourSearch', true))) 
  
	return	$totals
			.$hours_table;
}
