<?php
//test
require_once('include/all_includes.php');
$p = new Project();
$s = getOne( 'Staff', array('First_Name'=>'Ted'));
$p->set( array(
	'id' => 20971,
	'name' => 'SimpeTest Project',
	'staff_id' => $s->id,
	'company_id' => 20970
));
$p->save() ? print 'saved' : print 'didn\'t save';
?>