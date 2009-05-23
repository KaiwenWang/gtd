<?php
trigger_error("************* MODEL TESTS STARTING ***********");
require_once( '../gtd_includes.php');
require_once( 'simpletest/autorun.php');
//$db = AMP_Registry::getDbcon( );
#$db = getDbcon( );

class testHour extends UnitTestCase {
	function testGetters( ) {
#		global $db;
        $id = 20973;
        $h = new Hour( $id);
        $this->assertEqual( $h->getHours( ), 99.5);
        $this->assertEqual( $h->getDiscount( ), 96.5);
	}
}
class testEstimate extends UnitTestCase {
	function testGetters( ) {
#		global $db;
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
	function testGetters( ) {
		#global $db;
        $id = 20971;
        $p = new Project(  $id);
		$estimates= $p->getEstimates();
		$this->assertIsA($estimates,'array');
		$this->assertEqual(count($estimates),2);
		foreach ($estimates as $e){
			$this->assertIsA($e, 'Estimate');
		}
		$invoices = $p->getInvoices();
		$this->assertEqual(count($invoices),1);
		$this->assertIsA($invoices,'array');
		foreach ($invoices as $h){
			$this->assertIsA($h, 'Invoice');
		}
		$hours = $p->getHours();
		$this->assertEqual(count($hours),3);
		$this->assertIsA($hours,'array');
		foreach ($hours as $h){
			$this->assertIsA($h, 'Hour');
		}
		$this->assertEqual($p->getTotalHours(), 107); 
		$this->assertEqual($p->getBillableHours(), 8.5);
		$this->assertEqual($p->getLowEstimate(), 97.5);
		$this->assertEqual($p->getHighEstimate(), 101.5);
	}
}
class testSupportContract extends UnitTestCase {
	function testGetters( ) {
		global $db;
        $id = 20978;
        $p = new SupportContract( $id);
		$invoices = $p->getInvoices();
		$this->assertEqual(count($invoices),1);
		$this->assertIsA($invoices,'array');
		foreach ($invoices as $h){
			$this->assertIsA($h, 'Invoice');
		}
		$hours = $p->getHours();
		$this->assertEqual(count($hours),2);
		$this->assertIsA($hours,'array');
		foreach ($hours as $h){
			$this->assertIsA($h, 'Hour');
		}
		$this->assertEqual($p->getTotalHours(), 5.5); 
		$this->assertEqual($p->getBillableHours(), 3.5);
	}
}
class testInvoiceItem extends UnitTestCase {
	function testGetters( ) {
		global $db;
        $id = 20992;
        $i = new InvoiceItem ( $id);
		$this->assertEqual($i->getAmount(),33);
	}
}
class testInvoice extends UnitTestCase {
	function testGetters( ) {
		global $db;
        $id = 20991;
        $i = new Invoice ( $id);
		$invoice_items = $i->getInvoiceItems();
		$this->assertEqual(count($invoice_items),1);
		$this->assertIsA($invoice_items,'array');
		foreach ($invoice_items as $item){
			$this->assertIsA($item, 'InvoiceItem');
		}
		$this->assertEqual($i->getAmount(), 33);
	}
}
class testCompany extends UnitTestCase {
	function testGetters( ) {
		global $db;
        $id = 20970;
        $c = new Company( $id);
		$this->assertEqual($c->getName(),'SimpleTest Company');
		$projects= $c->getProjects();
		$this->assertIsA($projects,'array');
		$this->assertEqual(count($projects),1);
		foreach ($projects as $p){
			$this->assertIsA($p, 'Project');
		}
		$support_contracts= $c->getSupportContracts();
		$this->assertIsA($support_contracts,'array');
		$this->assertEqual(count($support_contracts),1);
		foreach ($support_contracts as $s){
			$this->assertIsA($s, 'SupportContract');
		}
		$invoices = $c->getInvoices();
		$this->assertEqual(count($invoices),2);
		$this->assertIsA($invoices,'array');
		foreach ($invoices as $i){
			$this->assertIsA($i, 'Invoice');
		}
		$payments = $c->getPayments();
		$this->assertEqual(count($payments),1);
		$this->assertIsA($payments,'array');
		foreach ($payments as $h){
			$this->assertIsA($h, 'Payment');
		}
		$this->assertEqual($c->getTotalPayments(), 900);
		$this->assertEqual($c->getTotalInvoices(), 99);
		$this->assertEqual($c->getBalance(), -801);
	}
}
?>
