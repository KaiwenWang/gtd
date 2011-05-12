<?php
function projectHourEditor( $data, $o = array()){
	$hour = $data['hour'];
  $project_id = $data['project_id'];
  
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
											  'selected_value' => $project_id
											  )
										  );

	$hour_edit_form = $r->view('hourEditForm',$hour, array('project_id'=>$project_id));
	
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
