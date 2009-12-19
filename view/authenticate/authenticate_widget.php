<?php
	function authenticateWidget($d){
		$r = getRenderer();
		if ($d->is_logged_in){
			$message = $r->link('Staff',array('action'=>'show','id'=>$d->user->id),'Hi '.$d->user->getName().'!').' '.$r->link('Authenticate',array('action'=>'destroy_session'),'Logout');
		}else{
			$message = $r->link('Authenticate',array('action'=>'login'),'Login');
		}
		return array('body'=>'<div id="login-widget">'.$message.'</div>');
	}
?>
