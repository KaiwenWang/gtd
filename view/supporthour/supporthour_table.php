<?php
function supporthourTable( $hours, $o = array()){
    $r =& getRenderer();
    if( !$hours ) return false;

// Table
    $table = array();
    $table['headers'] = array(	'ID',
    							'Description',
                                'Date Completed',
    							'Staff',
    							'Hours',
    							'Discount',
    							'Billable Hours',
								'Edit',
								'Delete'
    							);
    $table['rows'] =  array();
    $total_hours = 0;
    $billable_hours = 0;
    foreach($hours as $h){
      $total_hours += $h->getHours();
      $billable_hours += $h->getBillableHours();
      $table['rows'][] = array(	
      							UI::link( array( 'controller'=>'SupportHour', 'action'=>'show','id'=>$h->id, 'text'=>$h->id)),
      							UI::link( array( 'controller'=>'SupportHour', 'action'=>'show','id'=>$h->id, 'text'=>$h->getName())),
      							$h->getData('date'),
      							$h->getStaffName(),
      							$h->getHours(),
      							$h->getDiscount(),
      							$h->getBillableHours(),
      							UI::button( array( 'controller'=>'SupportHour', 'action'=>'show','id'=>$h->id)),
      							UI::button( array( 'controller'=>'SupportHour', 'action'=>'destroy','id'=>$h->id))
      							);
    }
    if ( !isset($o['title'])) $o['title'] = 'Hours';
    $html = 
         '<div class="totals-data totals-hours"><h3 class="basic-table-header">Total Support Hours: ' . $total_hours . '</h3></div>'
        . '<div class="totals-data totals-hours"><h3 class="basic-table-header">Billable Support Hours: ' . $billable_hours . "</h3></div>"
        . $r->view( 'basicTable', $table,
          array('title'=>'Support Hours', $o)) ;
    return $html;
}
