<?php
function projectHourLoggerForm( $projects, $o = array()){
	$r = getRenderer();

	$form = new Form( array(
						'controller'=>'Hour',
						'action'=>'log_hours_for_project',
						'method'=>'get',
						'ajax_target_id'=>'log-hours-for-project',
						'auto_submit'=>'project_id'
					));

	$form->contents = $r->classSelect( 'Project', array( 'name'=>'project_id' ), array('active'=>'true'));
	
	return 	$form->html
			.'<div id="log-hours-for-project"></div>';
}
