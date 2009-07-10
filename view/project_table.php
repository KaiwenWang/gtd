<?php

function projectTable( $projects, $o = array()){
    $r =& getRenderer();
    $table = array();
    $table['headers'] = array(	'Project Name',
    							'Status',
    							'Project Manager',
    							'Launch Date',
    							'Billing Status',
    							'Total Cost Est'
    							);
    $table['rows'] =  array();
    foreach($projects as $p){
      $table['rows'][] = array('<a href="controller=ProjectDetail&project_id='.$p->id.'">'.$p->getName().'</a>',
      							$p->getData('status'),
      							$p->getStaffName(),
      							$p->getData('launch_date'),
      							$p->getData('billing_status'),
      							$p->getData('cost')
      							);
    }
    $html = $r->view('basicTable',$table);
    return $html;
}
?>