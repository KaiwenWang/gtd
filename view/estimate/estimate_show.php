<?php
function estimateShow($d){
        $r =& getRenderer();

		$controls = $r->view( 'jumpSelect', $d->e, array('project_id'=>$d->e->getData('project_id')));
		$p_info = $r->view( 'projectInfo', $d->project,  array( 'class'=>'float-left'));
		$e_info = $r->view( 'estimateInfo', $d->e, array( 'class'=>'float-left'));
        $hour_table = $r->view('hourTable', $d->e->getHours(), array('title'=>'Hours for '.$d->e->getName()));

        return array(
               'title' => $d->e->getName(),
               'controls'	=> $controls,
               'body' => $p_info.$e_info.$hour_table
               );
}
?>