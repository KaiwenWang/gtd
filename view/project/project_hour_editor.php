<?php
function projectHourEditor( $data, $o = array()){
	$projects = $data['projects'];
	$hour = $data['hour'];

	$r = getRenderer();

	$form = new Form( array(
						'controller'=>'Hour',
						'action'=>'edit_form',
						'method'=>'get',
						'ajax_target_id'=>'edit-hours-for-project',
						'auto_submit'=>'project_id',
						'hour_id' => $hour->id
						));

	$form->content = $r->classSelect( 'Project',
									   array( 'name'=>'project_id',
											  'select_none'=>'Choose Project',
											  'selected_value' => $hour->getProject()->id
											  ),
									   array('active'=>'true'));

	$hour_edit_form = $r->view('hourEditForm',$hour);
	return 	'
			<div class="basic-form-contents">
				<h4>Choose Project</h4>
				'.$form->html.'
			</div>
			<div id="edit-hours-for-project">
				'.$hour_edit_form.'
			</div>
			';
}
