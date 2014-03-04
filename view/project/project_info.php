<?php

function projectInfo($p, $o = array()) {
  $r = getRenderer();
  $p->get('launch_date') 
    ? $launch_date = date('m/d/Y', strtotime($p->get('launch_date')))
    : $launch_date = 'NOT SET';
  
  if($launch_date == '11/30/-0001') {
    $launch_date = 'N/A';
  }
         
  $html = '
    <div>
      Project: ' . $r->link('Project', array('action' => 'show', 'id' => $p->id), $p->get('name')).'
    </div>
    <div>
      Company: ' . $r->link('Company', array('action' => 'show', 'id' => $p->get('company_id')),$p->getCompanyName()) . '
    </div>
    <div>
    <span class="launch-date">Launch Date: ' . $launch_date . '</span>    
    </div>
    <div>
    <span class="status-label">
      Status: 
    </span>
    <span class="status">' . $p->get('status') . '</span>
    </div>
    <div>
      <span class="project-manager-label">Project Manager: </span>
      <span class="project-manager">' . $r->link('Staff', array('action' => 'show', 'id' => $p->get('staff_id')), $p->getStaffName()) . '</span>
      </div>';

  if($p->get('designer')) {
    $html .= '
      <div>
        Designer: ' . $p->get('designer') . '
      </div>';
  }
  $percent = intval($p->getBillableHours() / $p->getHighEstimate() * 100) ;
  $pclass = $percent > 80 ? 'overbudget' : '';
  $html .= '
    <div class="detail-project-hours">
      <span class="float-left">Low Estimate: ' . $p->getLowEstimate() . '</span>    
      <span class="float-left">Hour Cap: ' . $p->get('hour_cap') . '</span>
      <span class="float-left">High Estimate: ' . $p->getHighEstimate() . '</span>      
      <span class="float-left">Hourly Rate: ' . $p->get('hourly_rate') . '</span>
      <span class="float-left">Total Hours Worked: ' . $p->getTotalHours() . '</span>
      <span class="float-left">Total Billable Hours : ' . $p->getBillableHours() . '</span>
      <span class="float-left">Server: ' . $p->get('server') . '</span>
      <div class="clear-left"></div>
      <div class="bar">
        <div class="filling ' . $pclass . '" style="width:5%">
          ' . $percent . '%
        </div>
      </div>
      <script type="text/javascript">
        $(function() {
          $(".filling").animate({"width":"' . $percent . '%"}, 1000);  
        });
      </script>
    </div>';

  return $html;
}

?>
