<?php
function staffShow($d){
	$r = getRenderer();
	
    $staff_detail = $r->view( 'staffDetail', $d->staff);

    $project_table = $r->view( 'projectTable', $d->staff->getProjects());

    return  array(	'title'=>$d->staff->getName(),
                    'controls'=>$r->view( 'jumpSelect', $d->staff),
                    'body'=>$staff_detail.$project_table
                    );
}
?>