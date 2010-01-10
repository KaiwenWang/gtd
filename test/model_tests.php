<?php
class testAmpOrm extends UnitTestCase {
	function testCloneRecord(){
        $id = 20973;
        $old_hour = new Hour( $id);
        $this->assertEqual( $old_hour->getHours( ), 99.5);
		$new_hour = $old_hour->cloneRecord();
        $this->assertEqual( $new_hour->getHours( ), 99.5);
        $this->assertFalse( $new_hour->id );
	}
}
class testActiveRecord extends UnitTestCase{
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
class testHour extends UnitTestCase {
	function testGetters( ) {
        $id = 20973;
        $h = new Hour( $id);
        $this->assertEqual( $h->getHours( ), 99.5);
        $this->assertEqual( $h->getDiscount( ), 96.5);
	}
}
class testEstimate extends UnitTestCase {
	function testGetters( ) {
        $id = 20972;
        $e = new Estimate( $id);
		$hours = $e->getHours();
		$this->assertIsA($hours,'array');
		$this->assertEqual(count($hours),2);
		foreach ($hours as $h){
			$this->assertIsA($h, 'Hour');
		}
		$this->assertTrue($e->getTotalHours() == 102); 
		$this->assertTrue($e->getBillableHours() == 4.5);
		$this->assertTrue($e->getLowEstimate() == 95);
		$this->assertTrue($e->getHighEstimate() == 98);
	}
}
class testProject extends UnitTestCase {
	function setUp(){
        $id = 20971;
        $this->project = new Project(  $id);	
	}
	function testGetEstimates( ) {

		$estimates= $this->project->getEstimates();
		$this->assertIsA($estimates,'array');
		$this->assertEqual(count($estimates),2);
		foreach ($estimates as $e){
			$this->assertIsA($e, 'Estimate');
		}
	}
	function testGetHours(){	
		$hours = $this->project->getHours();
		$this->assertEqual(count($hours),3);
		$this->assertIsA($hours,'array');
		foreach ($hours as $h){
			$this->assertIsA($h, 'Hour');
		}
	}
	function testFinder(){
		$finder = new Project();
		$projects = $finder->find( array('company_id'=> '20970'));
		$this->assertIsA($projects,'array');
		$this->assertEqual(count($projects),1);		
	}
	function testGetCalculations(){
		$this->assertEqual($this->project->getTotalHours(), 107); 
		$this->assertEqual($this->project->getBillableHours(), 8.5);
		$this->assertEqual($this->project->getLowEstimate(), 97.5);
		$this->assertEqual($this->project->getHighEstimate(), 101.5);
	}
}
class testSupportContract extends UnitTestCase {
	function setUp( ) {
        $id = 20978;
        $this->contract = new SupportContract( $id);
	}
	function testGetHours(){
		$hours = $this->contract->getHours();
		$this->assertEqual(count($hours),2);
		$this->assertIsA($hours,'array');
		foreach ($hours as $h){
			$this->assertIsA($h, 'Hour');
		}
		$this->assertEqual($this->contract->getTotalHours(), 5.5); 
		$this->assertEqual($this->contract->getBillableHours(), 3.5);
	}
}

class testCompany extends UnitTestCase {
	function setUp( ) {
        $id = 20970;
        $this->company = new Company( $id);
	}
	function testGetProjects(){
		$this->assertEqual($this->company->getName(),'SimpleTest Company');
		$projects= $this->company->getProjects();
		$this->assertIsA($projects,'array');
		$this->assertEqual(count($projects),1);
		foreach ($projects as $p){
			$this->assertIsA($p, 'Project');
		}
	}
	function testGetSupportContracts(){
		$support_contracts= $this->company->getSupportContracts();
		$this->assertIsA($support_contracts,'array');
		$this->assertEqual(count($support_contracts),1);
		foreach ($support_contracts as $s){
			$this->assertIsA($s, 'SupportContract');
		}
	}
}

?>
