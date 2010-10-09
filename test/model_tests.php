<?php
class testActiveRecord extends UnitTestCase{
	function testSave(){
		$c = new Company();
		$this->assertFalse($c->id, 'should not have an id yet');
		$c->set(array('name'=>'save_test'));
		$c->save();
		$this->assertTrue($c->id, 'should have an id');

		$this->assertEqual($c->get('name'),'save_test', 'name should be save_test');
		$c2 = new Company($c->id);
		$this->assertEqual($c2->get('name'),'save_test', ' reloaded item name should also be save_test');
	}
	function testDestroyAssociatedRecords(){
		$c = new Company();
		$c->set(array('name'=>'destroy_test'));
		$c->save();
		$p = new Project();
		$p->set(array('company_id'=>$c->id, 'name'=>'destroy_project_test'));
		$p->save();
		$e = new Estimate();
		$e->set(array('project_id'=>$p->id, 'name'=>'destroy_estimate_test'));
		$e->save();
		$h = new Hour();
		$h->set(array('estimate_id'=>$e->id, 'name'=>'destroy_hour_test'));
		$h->save();
		$ch = new Charge();
		$ch->set(array('company_id'=>$c->id, 'name'=>'destroy_charge_test'));
		$ch->save();
		$con = new SupportContract();
		$con->set(array('company_id'=>$c->id, 'name'=>'destroy_contract_test'));
		$con->save();
		$sup_hr = new Hour();
		$sup_hr->set(array('support_contract_id'=>$con->id,'description'=>'destroy_support_hour_test'));
		$sup_hr->save();
		$pay = new Payment();
		$pay->set(array('company_id'=>$c->id,'name'=>'destroy_payment_test'));
		$pay->save();

		$deleted_items = array(
			'company'=>$c->id,
			'project'=>$p->id,
			'estimate'=>$e->id,
			'hour'=>$h->id,
			'support_hour'=>$sup_hr->id,
			'charge'=>$ch->id,
			'support_contract'=>$con->id,
			'payment'=>$pay->id
		);

		$c->destroyAssociatedRecords();
		$c->delete();
	
        $dbcon = AMP::getDb();
		
		foreach($deleted_items as $table => $id){
			if( $table == 'support_hour' ) $table = 'hour';
			$sql = 'SELECT * FROM '. $table .' WHERE id = '. $id ;
			if( $records = $dbcon->Execute($sql)){

				$this->assertEqual( $records->RecordCount(), 0, "$table not deleted correctly: %s");

			} else {

				trigger_error($dbcon->ErrorMsg());

			}
		}
	}
}
