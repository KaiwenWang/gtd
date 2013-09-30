<?php
function clientuserTable( $clientusers, $o=array()){

    $r = getRenderer();

	$table = array();
	$table['headers'] = array('First Name','Last Name','Email','Client','Edit','Delete');
	$table['rows'] = array();

	foreach( $clientusers as $c){
		$client_link = UI::link(array(
							'controller'=>'Company',
							'action'=>'show',
							'id'=>$c->get('company_id'),
							'text'=>$c->getCompanyName()
						));
		$edit_link = UI::button(array(
							'controller'=>'ClientUser',
							'action'=>'edit',
							'id'=>$c->id
						));
		$delete_link = UI::button(array(
							'controller'=>'ClientUser',
							'action'=>'destroy',
							'id'=>$c->id
						));
		$table['rows'][] = array(
							$c->getFirstName(),
							$c->getLastName(),
							$c->getEmail(),
							$client_link,
							$edit_link,
							$delete_link
							);
	}

	return $r->view('basicTable',$table, array('title'=>'Search Client Users', 'pager' => true));
}
