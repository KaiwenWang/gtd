<?php
class ClientController extends PageController{
	//$authentication_type = 'client';

	function index($params){
		$params['id']	? $this->data->company = new Company( $params['id'])
				: bail('no company selected');
	}
}
