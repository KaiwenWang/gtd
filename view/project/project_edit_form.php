<?php
function projectEditForm( $p, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'Project', 'action'=>'update'));
    $fs = $form->getFieldSetFor($p);

	$form->content = '
			<div class="float-right">
    			<span style="float:right">Status: '.$fs->status.'</span>
    			<br>
				<span style="float:right">Launch Date: '.$fs->launch_date.'</span>
			</div>
	  		<div>
    				Company: '.$fs->company_id.'
    		</div>
    		<div>
    			Project Manager: '.$fs->staff_id.'
    		</div>
    		<div>
		    	Designer: '.$fs->desinger.'
			</div>
			<div class="detail-project-hours">
		    	<span>Hour Cap: '.$fs->hour_cap.'</span>
		    	<span>Hourly Rate: '.$fs->hourly_rate.'</span>
			</div>
			';

    return '
    	<div class="detail-list">
			'.$form->html.'
			<div class="clear"></div>
    	</div>
    ';
}
?>
