<?php
	function authenticateWidget($d){
		$r = getRenderer();
		if ($d->is_logged_in){
                  $message = '<div class="auth-widget-greeting">' . $r->link('Staff',array('action'=>'show','id'=>$d->user->id),'Hello, '.$d->user->getName().'!') . '</div>' .  
                    '<div class="auth-widget-controls">&laquo;'.$r->link('Staff',array('action'=>'edit', 'id'=>$d->user->id),'Edit Yourself') . '&raquo;' .
                    '&nbsp;&nbsp;&nbsp;&laquo;'.$r->link('Authenticate',array('action'=>'destroy_session'),'Log Out') . '&raquo;</div>';
		} else {
			$message = $r->link('Authenticate',array('action'=>'login'),'Log In');
		}
		return array('body'=>'<div id="login-widget">'.$message.'</div>');
	}
?>
