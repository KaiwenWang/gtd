<?php
class testInvoicing extends UnitTestCase {
	function testSendEmail(){
		$company = new Company();
		$company->set(array('name'=>'Test Company'));
		$company->save();

		$contact = new Contact();
		$contact->set(array('first_name'=>'Testy','last_name'=>'test','email'=>'ted@radicaldesigns.org','is_billing_contact'=>true,'company_id'=>$company->id));
		$contact->save();
	
		$i = new Invoice();
		$i->set(array('company_id'=>$company->id,'start_date'=>'2010-01-01','end_date'=>'2010-03-31'));
		$i->execute();
		$i->save();
	
		# here i test sending my invoice
		require_once('controller/InvoiceController.php');
		$invoice_controller = new InvoiceController();
		$invoice_controller->disableRedirect();
		$invoice_controller->execute('email',array('id'=>$i->id));
		
		$msg = Render::_dumpMessages();
		$this->assertPattern('/Email Sent/',$msg);
	}
}
