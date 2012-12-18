<?php
function staffShow($d){
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

  $hours_this_month = $r->view('basicMessage','Hours this month: '.$d->hours_this_month);
  $billable_hours_this_month = $r->view('basicMessage','Billable Hours this month: '.$d->billable_hours_this_month);

  $hours_this_week = $r->view('basicMessage','Hours this week: '.$d->hours_this_week);
  $billable_hours_this_week = $r->view('basicMessage','Billable Hours this week: '.$d->billable_hours_this_week);
  $hours_summary = '
      <div id="hours-summary" class="detail-list">
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
                     '',
                      array('ajax_target_id'=>'hour-search-1')
                    );

  $highchart_graph = "<div id='rd-graph' class='rd-graph' data-staff='".$d->graph['staff']."' data-call='overview'></div>
      <div id='rd-graph_navigate'></div>
      <div id='rd-graph_control'></div>";

    return  array(  
      'title'=>$d->staff->getName().'land',
      'body'=> $hidden_forms
              .$hours_summary
              .$highchart_graph
              .$hour_table
    );
}
