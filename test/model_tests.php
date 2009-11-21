<?php
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
