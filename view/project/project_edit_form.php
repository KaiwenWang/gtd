<?php
function projectEditForm( $p, $o = array()){
    $r =& getRenderer();
    $form = new Form( array( 'controller'=>'project', 'action'=>'update'));
    $fs = $form->getFieldSetFor($p);
    return '
    	<div class="detail-list">
    		<div>
    			<span>
    				Company: '.$fs->company_id.'
    	   		</span>
    			<span style="float:right">Launch Date: '.$fs->launch_date.'</span>
    		</div>
    		<div>
    			<span>Project Manager: '.$fs->staff_id.'
		    	Designer: '.$fs->desinger.'
    	   		</span>
    			<span style="float:right">Status: '.$fs->status.'</span>
			</div>
			<div class="detail-project-hours">
		    	<span>Hour Cap: '.$fs->hour_cap.'</span>
		    	<span>Hourly Rate: '.$fs->hourly_rate.'</span>
			</div>
    	</div>
    ';
}
?>
