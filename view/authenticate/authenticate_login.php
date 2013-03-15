<?php
function authenticateLogin($d){
	$r = getRenderer();

	$form = new Form( array('controller'=>'Authenticate', 
							'action'=>'create_session',
							'id'=>'login-form'
							)
					);

	$form->content = '
        <div class="bs-docs-example" id="Login">
				<label for="ematil"><strong>Email</strong></label>
				<input type="text" name="email" value="'.$d->email.'" />
				<label for="password"><strong>Password</strong></label>
				<input type="password" name="password" />
				<p>'.$form->submitBtn.'</p>
			</div>
			';
	
	return array(	'title'=>'Staff Login',
					'controls'=>'',
					'body'=>$form->html
				);
}
