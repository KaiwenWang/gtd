<?php

function projectHourLoggerForm($projects, $o = array()) {
  $r = getRenderer();

  $form = new Form(array(
    'controller' => 'Hour',
    'action' => 'new_form',
    'method' => 'get',
    'ajax_target_id' => 'log-hours-for-project',
    'auto_submit' => 'project_id'
  ));

  $form->content = $r->classSelect('Project', array('name' => 'project_id'), array('active' => 'true'));
  
  return '
    <div class="basic-form-contents">
    <h4>Choose Project</h4>
    ' . $form->html . '
    </div>
    <div id="log-hours-for-project"></div>
    ';
}

?>
