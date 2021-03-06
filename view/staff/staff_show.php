<?php

function staffShow($d) {
  $r = getRenderer();

  if(is_array($d->billable_hours_this_week)) {
    $start_date = isset($d->dates['start_date']) ? $d->dates['start_date'] : '';
    $end_date   = isset($d->dates['end_date']) ? $d->dates['end_date'] : '';
    $search_form = new Form(array(
      'method' => 'get',
      'controller' => 'Staff',
      'action' => 'show'
    ));

    $search_form->content = '<div id="staff_show_dates">
      <div class="search-input">
        <label for="staff_show_start">Start Date</label>
        ' . $r->input('date', array(
          'name' => 'start_date',
          'value' => $start_date,
          'id' => 'staff_show_start'
        )).'
      </div>
      <div class="search-input">
        <label for="staff_show_end">End Date</label>
        ' . $r->input('date', array(
          'name' => 'end_date',
          'value' => $end_date,
          'id' => 'staff_show_end'
        )) . '
      </div>
    </div>';

    $hours = $search_form->html;
    $hours .= '<div class="hours-race">';
    arsort($d->billable_hours_this_week);
    $place = 1;
    $most_hours = 0.00000001;
    if(max($d->billable_hours_this_week) > $most_hours) {
      $most_hours = max($d->billable_hours_this_week);
    }
    foreach($d->billable_hours_this_week as $id => $billable) {
      $percent = ($d->billable_hours_this_week[$id] / $most_hours) * 100;
      $hours .= '<div class="contestant">
      <div class="placement">#' . $place . '</div>
      <div class="contestant-data">
        <div class="name">' . $d->staff[$id] . '</div>' . 
        '<div class="stats"><strong>Billable:</strong> ' . $d->billable_hours_this_week[$id] . ' | <strong>Total:</strong> ' . $d->total_hours_this_week[$id] . '</div>' . 
        '<div class="bar">
        <div class="filling bar-' . $id . ' ' . $pclass . ' place-' . $place . '" style="width: 5%">
          ' . $d->billable_hours_this_week[$id] . '
        </div>
        </div>
        <script>$(".bar-' . $id . '").animate({"width":"' . $percent . '%"}, 1000);</script>
      </div>
      <div class="clear"></div>
      </div>';
      $place++;
    }
    $hours .= '</div>';

    return array( 
      'title' => 'Ratrace',
      'body' => $hours
    );
  } else {
    $hidden_forms = $r->view('jsMultipleButtons', array(
      'Create New Project' => $r->view('projectNewForm', $d->new_project),
      'Log Project Hour' => $r->view('projectHourLoggerForm', $d->active_projects),
      'Log Support Hour' => $r->view('supporthourNewForm', $d->new_support_hour),
      'Edit My Shit' => $r->view('staffEditForm', $d->staff)
    ));

    $hours_this_month = $r->view('basicMessage', 'Hours this month: <span class="unbillable">' . $d->hours_this_month . '</span>');
    $billable_hours_this_month = $r->view('basicMessage', 'Billable hours this month: <span class="billable">' . $d->billable_hours_this_month . '</span>');

    $hours_this_week = $r->view('basicMessage', 'Hours this week: <span class="unbillable">' . $d->hours_this_week . '</span>');
    $billable_hours_this_week = $r->view('basicMessage', 'Billable hours this week: <span class="billable">'.$d->billable_hours_this_week . '</span>');
    $hours_summary = '
      <div class="bs-docs-example" id="Hours">
      <div class="hours-month">
      ' . $hours_this_month . '
      ' . $hours_this_week . '
      </div>
      <div class="hours-week">
      ' . $billable_hours_this_month . '
      ' . $billable_hours_this_week . '
      </div>
      <div class="clear-both"></div></div>';

    $hour_table = $r->view('hourSearch',
      $d->staff_hours,
      array('ajax_target_id' => 'hour-search-1')
    );

    $highchart_graph = "<div class='bs-docs-example' id='Graph'>
      <div id='rd-graph' class='rd-graph' data-staff='" . $d->graph['staff'] . "' data-call='overview'></div>
      <div id='rd-graph_navigate'></div>
      <div id='rd-graph_control'></div>
      </div>";

    return array( 
      'title' => $d->staff->getName() . 'land',
      'body' => $hidden_forms
        . $hours_summary
        . $highchart_graph
        . $hour_table
    );
  }
}

?>
