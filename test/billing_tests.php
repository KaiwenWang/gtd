<?php
class testBilling extends UnitTestCase {
	function testActiveMonths(){
		$sc = new SupportContract();
		$sc->set(array('start_date'=>'2010-01-01','end_date'=>'2010-04-30'));
		
		# Support Contract ends after the date range	
		$date_range = array('end_date'=>'2010-03-31');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 3);

		# Making sure that any date past the 1st counts as month
		$date_range = array('end_date'=>'2010-03-15');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 3);

		# Making sure that any day past the 1st doesn't count as month
		$date_range = array('end_date'=>'2010-03-02');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 3);

		# Making sure that the 1st doesn't count as a month
		$date_range = array('end_date'=>'2010-03-01');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 2);

	}
	
	function testActiveMonthsWithStartDate(){
		$sc = new SupportContract();
		$sc->set(array('start_date'=>'2010-01-01','end_date'=>'2010-04-30'));
		
		# Date range is entirely within the Support Contract 
		$date_range = array( 'start_date'=>'2010-02-01', 'end_date'=>'2010-03-31');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 2);
			
		# Date range matches the Support Contract 
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-04-30');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 4);
			
		# Date range end after Support Contract ends 
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-05-31');
		$months = $sc->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 4);
	}

	function testCalculateOneSupportContractTotal(){
		$sc = new SupportContract();
		$sc->set(array('domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
		$sc->save();

		$h = new Hour();
		$h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
		$h->save();

		$sc->destroyAssociatedRecords();
		$sc->delete();
	}

	function testGetHours(){
        $sc = new SupportContract();
        $sc->set(array('domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
        $sc->save();

        $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
        $h->save();

		$date_range = array('end_date'=>'2010-03-31');
		#Make sure we are getting the hours
		$hours = $sc->getHours(array('date_range'=>$date_range));
		$this->assertTrue( is_array($hours));
		$this->assertEqual( count($hours), 1);
		$hour  = array_pop($hours);
		$this->assertEqual( get_class($hour),'Hour');
		$this->assertEqual( $hour->getBillableHours(), 2.5);

		$sc->destroyAssociatedRecords();
		$sc->delete();
	}

	function testCaluclateTotalSteps(){
        $sc = new SupportContract();
        $sc->set(array('domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
        $sc->save();

        $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
        $h->save();

		$date_range = array('end_date'=>'2010-03-31');
		#make sure we are getting the active months
		$months = $sc->activeMonths($date_range);
		$this->assertEqual( count($months), 3);
		$this->assertEqual( array_pop($months), '201003');

		#make sure we are calculating monthly base rate
		$this->assertEqual($sc->calculateMonthlyBaseRate(201002),50);

		#make sure we are getting the hourly rate
		$this->assertEqual($sc->getHourlyRate(),120);
		$this->assertEqual($sc->get('hourly_rate'),120);

		#make sure we are calculating the monthly charge: base rate + logged hours - included support hours	
		$monthly_charge = $sc->calculateMonthlyCharge( $h->getHours(), '201002');
		$this->assertEqual( $monthly_charge, '290');

		$sc->destroyAssociatedRecords();
		$sc->delete();
	}

	function testCalculateTotal(){
        $sc = new SupportContract();
        $sc->set(array('domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
        $sc->save();

        $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
        $h->save();
		
		# Support Contract ends after date range 
		# Start Date: 2010-01-10
		# End Date: 2010-03-31
		# Number of months: 3
		# 3 monthes at 50 + 2 hours overage at 120 = 390	
		$date_range = array('end_date'=>'2010-03-31');
		$sc_total = $sc->calculateTotal($date_range);
		$this->assertEqual( $sc_total, 390);
		
		# Support Contract ends before date range 	
		# Start Date: 2010-01-10
		# End Date: 2010-04-30
		# Number of months: 4 
		# 4 monthes at 50 + 2 hours overage at 120 = 440	
		$date_range = array('end_date'=>'2010-05-31');
		$sc_total = $sc->calculateTotal($date_range);
		$this->assertEqual( $sc_total, 440);

		# Support Contract with no end date passed to it
		# Start Date: 2010-01-10
		# End Date: 2010-04-30
		# Number of months: 4 
		# 4 monthes at 50 + 2 hours overage at 120 = 440	
		$sc_no_end_date_total = $sc->calculateTotal();
		$this->assertEqual( $sc_no_end_date_total, 440);
		
		$sc->destroyAssociatedRecords();
		$sc->delete();
	}

	function testCalculateOneSupportContractTotalWithStartDate(){
        $sc = new SupportContract();
        $sc->set(array('domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
        $sc->save();

		# Hour is in date range
        $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
		$h->save();

		# Hour is out of date range
		$h = new Hour();
		$h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-01-20','hours'=>'1'));
        $h->save();
	
		# start date: 2010-02-01 end date: 2010-04-30	
		# 3 monthes at 50 + 2 hours at 120 = 390
		$date_range = array( 'start_date'=>'2010-02-01', 'end_date'=>'2010-05-31');
		$sc_total = $sc->calculateTotal($date_range);
		$this->assertEqual( $sc_total, 390);

		$date_range = array( 'start_date'=>'2010-02-01');
		$sc_no_end_date_total = $sc->calculateTotal($date_range);
		$this->assertEqual( $sc_no_end_date_total, 390);
	}

/*
	function testCalculateSupportTotal(){
		$date_range = array('end_date'=>'2010-08-15');
		$total = $this->company->calculateSupportTotal($date_range);
		$this->assertEqual( $total, 1825);
	}
	function testCalculateChargesTotalWithStartDate(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$charge_total = $this->company->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 55.22 );
	}
	function testCalculateChargesTotalWithStartDateBeforePreviousBalance(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$previous_balance = new CompanyPreviousBalance();
		$previous_balance->set(array(
								'company_id'=>$this->company->id,
								'balance'=>600.22,
								'date'=>'2010-01-21'
								)
							);
		$previous_balance->save();

		$charge_total = $this->company->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 30 );
	}
	function testCalculateChargesTotalWithNoDateRange(){
		$charge_total = $this->company->calculateChargesTotal(); 
		$this->assertEqual($charge_total, 90.44 );
	}
	function testCalculatePaymentsTotalWithDateRange(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$payment_total = $this->company->calculatePaymentsTotal($date_range);
		$this->assertEqual($payment_total, 650.50);
	}
	function testCalculatePaymentsTotalWithDateRangeAndPreviousBalance(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$previous_balance = new CompanyPreviousBalance();
		$previous_balance->set(array(
								'company_id'=>$this->company->id,
								'balance'=>600.22,
								'date'=>'2010-03-21'
								)
							);
		$previous_balance->save();

		$payment_total = $this->company->calculatePaymentsTotal($date_range);
		$this->assertEqual($payment_total, 150.50);
	}
	function testCalculatePaymentsTotalWithoutDateRange(){
		$payment_total = $this->company->calculatePaymentsTotal();
		$this->assertEqual($payment_total, 951);

	}
	function testCalculateProjectTotalWithDateRange(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		
		$total = $this->company->calculateProjectsTotal( $date_range );
		$this->assertEqual($total,500);
	}
	function testCalculateProjectTotalWithStartDateBeforePreviousBalanceDate(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$previous_balance = new CompanyPreviousBalance();
		$previous_balance->set(array(
								'company_id'=>$this->company->id,
								'balance'=>600.22,
								'date'=>'2010-03-21'
								)
							);
		$previous_balance->save();	
		
		$total = $this->company->calculateProjectsTotal( $date_range );
		$this->assertEqual($total,100);
	}
	function testCalculateProjectTotalWithoutDateRange(){
		$total = $this->company->calculateProjectsTotal();
		$this->assertEqual($total,600);
	}
	function testCalculateCostWithStartDateBeforePreviousBalanceDate() {
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$previous_balance = new CompanyPreviousBalance();
		$previous_balance->set(array(
								'company_id'=>$this->company->id,
								'balance'=>600.22,
								'date'=>'2010-03-21'
								)
							);
		$previous_balance->save();	
		$total = $this->company->calculateCosts( $date_range ); 
		$this->assertEqual($total, 650);
	}
	function testCalculateCostWithDateRange() {
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$total = $this->company->calculateCosts( $date_range ); 
		$this->assertEqual($total, 2380.22);
	}
	function testCalculateBalanceWithDateRange(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$balance = $this->company->calculateBalance( $date_range );
		$this->assertWithinMargin( $balance, 2329.72, 0.001);
	}
	function testCalculateBalanceWithStartDateBeforePreviousBalance(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$previous_balance = new CompanyPreviousBalance();
		$previous_balance->set(array(
								'company_id'=>$this->company->id,
								'amount'=>600.22,
								'date'=>'2010-03-21'
								)
							);
		$previous_balance->save();	
		
		$balance = $this->company->calculateBalance( $date_range );
		$this->assertEqual( $balance, 1099.72);
	}
	function testInvoiceCreationWithDateRange(){
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-08-15');
		$previous_balance_date = array('end_date'=>$date_range['start_date']);
		$amount_due_date = array('end_date'=>$date_range['end_date']);
		$previous_balance = $this->company->calculateBalance( $previous_balance_date);
		$new_costs = $this->company->calculateCosts($date_range);
		$new_payments = $this->company->calculatePaymentsTotal($date_range);
		$amount_due = $this->company->calculateBalance($amount_due_date);

		$i = new Invoice();
		$i->set(array(
				'company_id'=>$this->company->id,
				'type'=>'quarterly',
				'start_date'=>$date_range['start_date'],
				'end_date'=>$date_range['end_date'],
				'previous_balance'=>$previous_balance,
				'new_costs'=>$new_costs,
				'amount_due'=>$amount_due,
				'new_payments'=>$new_payments
				)
			);
		$i->save();

		$i2 = new Invoice();
		$i2->setFromCompany( $this->company, $date_range);
		$i2->save();

		$this->assertEqual( $i->get('new_costs'), $i2->getNewCosts());
		$this->assertEqual( $i->get('previous_balance'), $i2->getPreviousBalance());
		$this->assertEqual( $i->get('new_payments'), $i2->getNewPaymentsTotal());
		$this->assertEqual( $i->get('amount_due'), $i2->getAmountDue());

		$i3 = new Invoice();
		$i3->set(array(
				'company_id'=>$this->company->id,
				'start_date'=>$date_range['start_date'],
				'end_date'=>$date_range['end_date'],
				)
			);
		$i3->execute();
		$i3->save();

		$this->assertEqual( $i->get('new_costs'), $i3->getNewCosts());
		$this->assertEqual( $i->get('previous_balance'), $i3->getPreviousBalance());
		$this->assertEqual( $i->get('new_payments'), $i3->getNewPaymentsTotal());
		$this->assertEqual( $i->get('amount_due'), $i3->getAmountDue());
	}
	 */
}
