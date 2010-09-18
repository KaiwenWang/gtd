<?php
function staffShow($d){
	$r = getRenderer();

	$hidden_forms = $r->view( 'jsMultipleButtons' ,array(
														
						'Create New Project'	=> $r->view(
													'projectNewForm', 
													$d->new_project
												),
						'Log Project Hour' => $r->view(
													'projectHourLoggerForm',
													$d->active_projects
												),
						'Log Support Hour'	=> $r->view(
													'supporthourNewForm', 
													$d->new_support_hour
												),
						'Edit My Shit'	=> $r->view(
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
    $project_table = $r->view( 'projectTable', $d->staff->getProjects());

    $hour_table = $r->view( 'hourTable', $d->staff->getHours());

    return  array(	'title'=>$d->staff->getName().'land',
                    'controls'=>$r->view( 'jumpSelect', $d->staff),
                    'body'=> $hidden_forms
							.$hours_summary
                    		.$project_table
							.$hour_table
                    );
}
