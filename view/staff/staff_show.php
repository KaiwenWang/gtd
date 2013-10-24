<?php
function staffShow($d){
  if(is_array($d->billable_hours_this_week)) {
    $hours = '<div class="hours-race">';
    $js = '<script type="text/javascript">
      $(function(){
    ';
    foreach($d->billable_hours_this_week as $id => $billable) {
      $percent = ($d->billable_hours_this_week[$id] / 40) * 100;
      $pclass = $percent > 37.5 ? 'overbudget' : '';
      $hours .= '<div class="contestant">
        ' . $d->staff[$id] . '
        <div class="bar">
          <div class="filling-' . $id . ' ' . $pclass . '" style="width: 5%">
            ' . $d->billable_hours_this_week[$id] . '
          </div>
        </div>
      </div>';
      $js .= '$(".filling-' . $id . '").animate({"width":"' . $percent . '%"}, 1000);
      ';    
    }
    $js .= '});
    </script>';
    $hours.= '</div>';

    return  array(  
      'title'=>'RadicalKart 64',
      'body'=> $hours
        . $js
    );
  } else {
    $r = getRenderer();

    $hidden_forms = $r->view( 'jsMultipleButtons' ,array(

      'Create New Project'  => $r->view(
        'projectNewForm', 
        $d->new_project
      ),
      'Log Project Hour' => $r->view(
        'projectHourLoggerForm',
        $d->active_projects
      ),
      'Log Support Hour'  => $r->view(
        'supporthourNewForm', 
        $d->new_support_hour
      ),
      'Edit My Shit'  => $r->view(
        'staffEditForm', 
        $d->staff
      )
    ));

    $hours_this_month = $r->view('basicMessage','Hours this month: <span class="unbillable">' . $d->hours_this_month . '</span>');
    $billable_hours_this_month = $r->view('basicMessage','Billable hours this month: <span class="billable">' . $d->billable_hours_this_month . '</span>');

    $hours_this_week = $r->view('basicMessage','Hours this week: <span class="unbillable">' . $d->hours_this_week . '</span>');
    $billable_hours_this_week = $r->view('basicMessage','Billable hours this week: <span class="billable">'.$d->billable_hours_this_week . '</span>');
    $hours_summary = '
      <div class="bs-docs-example" id="Hours">
      <div class="hours-month">
      '. $hours_this_month .'
      '. $hours_this_week .'
      </div>
      <div class="hours-week">
      '. $billable_hours_this_month.'
      '. $billable_hours_this_week .'
      </div>
      <div class="clear-both"></div></div>';

    $hour_table = $r->view('hourSearch',
      $d->staff_hours,
      array('ajax_target_id'=>'hour-search-1')
    );

    $highchart_graph = "<div class='bs-docs-example' id='Graph'>
      <div id='rd-graph' class='rd-graph' data-staff='".$d->graph['staff']."' data-call='overview'></div>
      <div id='rd-graph_navigate'></div>
      <div id='rd-graph_control'></div>
      </div>";

    return  array(  
      'title'=>$d->staff->getName().'land',
      'body'=> $hidden_forms
      .$hours_summary
      .$highchart_graph
      .$hour_table
    );
  }
}
