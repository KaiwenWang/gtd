<?php
	function authenticateWidget($d){
		$r = getRenderer();
		if ($d->is_logged_in){
			$message = $r->link('Staff',array('action'=>'show','id'=>$d->user->id),'Hello, '.$d->user->getName().'!').'&nbsp;&nbsp;&nbsp;&laquo;'.$r->link('Authenticate',array('action'=>'destroy_session'),'Log Out') . '&raquo;';
		} else {
			$message = $r->link('Authenticate',array('action'=>'login'),'Log In');
		}
		return array('body'=>'<div id="login-widget">'.$message.'</div>');
	}
?>
