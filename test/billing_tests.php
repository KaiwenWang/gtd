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

		# date range is 3 months at 50$ = 150 + 2 at 120 = 240 extra hours (2.5 - .5 support) = total 390 
		$date_range = array('start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$support_total = $sc->calculateTotal($date_range);
		$this->assertEqual($support_total, 390);

		## clean up
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

		## clean up
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

		## clean up
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

		## clean up	
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
	
		## clean up
		$sc->destroyAssociatedRecords();
		$sc->delete();
	
	}

	function testCalculateSupportTotal(){
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();

        $sc = new SupportContract();
        $sc->set(array('company_id'=>$cp->id,'domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
        $sc->save();

		# 2.5 Hours in date range
        $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
		$h->save();

		# Hour is out of date range
		$h = new Hour();
		$h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-04-20','hours'=>'1'));
        $h->save();
		
		# 3 months at 50 = 150 plus 2 hours overage at 120 = 240 + 150 = 390	
		$date_range = array('end_date'=>'2010-03-31');
		$total = $cp->calculateSupportTotal($date_range);
		$this->assertEqual($total, 390);
		
		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	}

	function testCalculateChargesTotalWithStartDate(){
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();

		# Charge in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-02-20','amount'=>'20.50'));
		$cr->save();
	
		# Charge in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-14','amount'=>'50.25'));
		$cr->save();
		
		# Charge out of first date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-20','amount'=>'20.50'));
		$cr->save();

		# 20.50 + 50.25 = 70.75 (20.50 not counted as out of range)
		$date_range = array( 'start_date'=>'2010-02-01', 'end_date'=>'2010-03-15');
		$charge_total = $cp->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 70.75 );
	
		# 20.50 + 50.25 + 20.50 = 91.25 (all charges in range) 
		$date_range = array( 'start_date'=>'2010-02-01', 'end_date'=>'2010-03-31');
		$charge_total = $cp->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 91.25 );
	
		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	}

	function testCalculateChargesTotalWithStartDateBeforePreviousBalance(){
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();
		
		$pb = new CompanyPreviousBalance();
		$pb->set(array( 'company_id'=>$cp->id, 'balance'=>600.25, 'date'=>'2010-01-21'));
		$pb->save();

		# Charge in date range but before previous balance
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-01-10','amount'=>'20.50'));
		$cr->save();
	
		# Charge in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-14','amount'=>'50.25'));
		$cr->save();
		
		# Charge in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-20','amount'=>'50'));
		$cr->save();

		# 20.50 Before Previous Balance so   50.25 + 50 = 100.25
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$charge_total = $cp->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 100.25 );
	
		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	}

	function testCalculateChargesTotalWithNoDateRange(){
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();
		
		$pb = new CompanyPreviousBalance();
		$pb->set(array( 'company_id'=>$cp->id, 'balance'=>600.25, 'date'=>'2010-01-21'));
		$pb->save();

		# Charge in date range but before previous balance
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-01-10','amount'=>'20.50'));
		$cr->save();
	
		# Charge in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-14','amount'=>'50.25'));
		$cr->save();
		
		# Charge in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-20','amount'=>'50'));
		$cr->save();

		# 20.50 Before Previous Balance so   50.25 + 50 = 100.25
		$charge_total = $cp->calculateChargesTotal(); 
		$this->assertEqual($charge_total, 100.25 );
	
		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	}
	function testGetBillableHours(){
		# with discount
		$e = new Estimate();
		$e->set(array('name'=>'i am a test!'));	
		$e->save();
		
		# gimme yo hours!
		$ho = new Hour();
		$ho->set(array('description'=>'did some stuff','date'=>'2010-02-25','hours'=>'2.75','estimate_id'=>$e->id,'discount'=>'1'));
		$ho->save();

	    # gimme yo hours!
		$ho2 = new Hour();
		$ho2->set(array('description'=>'did some more stuff','date'=>'2010-02-26','hours'=>'3','estimate_id'=>$e->id,'discount'=>'1'));
		$ho2->save();

		# 1.75 + 2 = 3.75

		$date_range = array('start_date'=>'2010-01-01','end_date'=>'2010-03-01');
		$billable_hours = $e->getBillableHours($date_range);
		$this->assertEqual($billable_hours,3.75);

		#destroy!!!!!
		$e->destroyAssociatedRecords();
		$e->delete();
	}
	function testCalculatePaymentsTotalWithDateRanges(){
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();
			
		# Previous Balance removes anything in 2010-01 
		$pb = new CompanyPreviousBalance();
		$pb->set(array( 'company_id'=>$cp->id, 'balance'=>600.25, 'date'=>'2010-01-31'));
		$pb->save();

		# Payment always out of  range
		$pm = new Payment();
		$pm->set(array( 'company_id'=>$cp->id,'amount'=>100, 'date'=>'2010-01-15'));
		$pm->save();

		# Payment always in range
		$pm = new Payment();
		$pm->set(array( 'company_id'=>$cp->id,'amount'=>200.25, 'date'=>'2010-02-15'));
		$pm->save();

		# Payment always in range
		$pm = new Payment();
		$pm->set(array( 'company_id'=>$cp->id,'amount'=>25, 'date'=>'2010-03-15'));
		$pm->save();
	
		# Payment only without range 
		$pm = new Payment();
		$pm->set(array( 'company_id'=>$cp->id,'amount'=>50, 'date'=>'2010-04-15'));
		$pm->save();

		# Test Payments in Date Range with Previous Balance in Range (200.25 + 25 = 625.25)
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$payment_total = $cp->calculatePaymentsTotal($date_range);
		$this->assertEqual($payment_total, 225.25);

		# Test Payments with no Date Range with Previous Balance (200.25 + 25 + 50 = 675.25) 
		$payment_total = $cp->calculatePaymentsTotal();
		$this->assertEqual($payment_total, 275.25);

		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	}


	function testCalculateProjectTotals(){
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();
	
		# Add a Project
		$pj = new Project();
		$pj->set(array( 'name'=>'Test Project','company_id'=>$cp->id,'hourly_rate'=>'120' ));
		$pj->save();
		
		# Add an Estimate item for the Project  - #1
		$es1 = new Estimate();
		$es1->set(array('project_id'=>$pj->id,'name'=>'Test Estimate 1','high_hours'=>'10','low_hours'=>'5'));
		$es1->save();
			
		# Add an Estimate item for the Project  - #2
		$es2 = new Estimate();
		$es2->set(array('project_id'=>$pj->id,'name'=>'Test Estimate 2','high_hours'=>'10','low_hours'=>'5'));
		$es2->save();

		# Add some hours for #1 Estimate item 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es1->id,'description'=>'Test Hours for Estimate 1','date'=>'2010-01-15','hours'=>'5'));
		$hr->save();
		
		# Add some hours for #2 Estimate item 5 hours at 120 = 600
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es2->id,'description'=>'Test Hours for Estimate 2','date'=>'2010-03-15','hours'=>'5'));
		$hr->save();
		
		# Add some hours for #2 Estimate item that are out of range, with no range add 600 more 
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es2->id,'description'=>'Test Hours for Estimate 2','date'=>'2010-05-15','hours'=>'5'));
		$hr->save();

		# Date Range: Get all the hours for a project based on date range and calculate cost
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateProjectsTotal( $date_range );
		$this->assertEqual($total,1200);

		# No Date Range: Get all the hours for a project with no date range and calculate cost
		$total = $cp->calculateProjectsTotal();
		$this->assertEqual($total,1800);
			
		# But wait what if Previous Balance removes anything in 2010-01 
		$pb = new CompanyPreviousBalance();
		$pb->set(array( 'company_id'=>$cp->id, 'balance'=>600.25, 'date'=>'2010-01-31'));
		$pb->save();

		# Date Range with Previous Balance:  Get all the hours for a project based on date range but with previous balance and calculate cost
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateProjectsTotal( $date_range );
		$this->assertEqual($total,600);

		# No Date Range with Previous Balance: Get all the hours for a project with no date range but with previous balance and calculate cost
		$total = $cp->calculateProjectsTotal();
		$this->assertEqual($total,1200);

		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	}

	function testCalculateCosts(){
		
		#Company 
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();
	
		$pb = new CompanyPreviousBalance();
		$pb->set(array( 'company_id'=>$cp->id, 'balance'=>600.25, 'date'=>'2010-02-01'));
		$pb->save();

		######### Support
		$sc = new SupportContract();
		$sc->set(array('company_id'=>$cp->id,'domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
		$sc->save();
		# add support hours 
		# before previous balance
	    $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-01-20','hours'=>'2.5'));
        $h->save();
		# in range 
		$h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
        $h->save();
		# in range
		$h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-03-20','hours'=>'2.5'));
        $h->save();
		# out of range
		$h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-05-20','hours'=>'2'));
        $h->save();
		### Support Totals = in range is 2 months x 50 = 100, 4 @ 120 = 480 = 580
		#### out of range = 6 @ 120 ??
		#### FIX ME it's counting the month of jan as asupport month!!! so we are getting 630 instea so we are getting 630 insteadd
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateSupportTotal($date_range);
		$this->assertEqual($total, 580);
		

		###### Project
		$pj = new Project();
		$pj->set(array( 'name'=>'Test Project','company_id'=>$cp->id,'hourly_rate'=>'120' ));
		$pj->save();
		# Add an Estimate item #1
		$es1 = new Estimate();
		$es1->set(array('project_id'=>$pj->id,'name'=>'Test Estimate 1','high_hours'=>'10','low_hours'=>'5'));
		$es1->save();
		# Add an Estimate item #2
		$es2 = new Estimate();
		$es2->set(array('project_id'=>$pj->id,'name'=>'Test Estimate 2','high_hours'=>'10','low_hours'=>'5'));
		$es2->save();
		# Add some before previous balance hours for #1 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es1->id,'description'=>'Test Hours for Estimate 1','date'=>'2010-01-15','hours'=>'5'));
		$hr->save();
		# Add some in range hours for #1 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es1->id,'description'=>'Test Hours for Estimate 1','date'=>'2010-02-15','hours'=>'5'));
		$hr->save();
		# Add some in range hours for #2 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es2->id,'description'=>'Test Hours for Estimate 2','date'=>'2010-02-15','hours'=>'5'));
		$hr->save();
		# Add some out of range hours for #2 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es2->id,'description'=>'Test Hours for Estimate 2','date'=>'2010-05-15','hours'=>'5'));
		$hr->save();
		## Project Totals = In range 1200, out of range 1800 
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateProjectsTotal( $date_range );
		$this->assertEqual($total,1200);


		#Charge
		# before previous balance
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-01-10','amount'=>'20.50'));
		$cr->save();
		# in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-14','amount'=>'50.25'));
		$cr->save();
		# in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-20','amount'=>'50'));
		$cr->save();
		# out of date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-05-15','amount'=>'50'));
		$cr->save();
		# Total Charges = in range 100.25, out of range 150.25 
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$charge_total = $cp->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 100.25 );
	
		## Test Total Costs	
		# Charges 100.25 + project 1200 + support 580 	
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateCosts( $date_range ); 
		$this->assertEqual($total, 1880.25);
	
		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();

	}
	function testEndOfMonthShouldBeDiscarded(){
		$date = '2010-01-28';
		$modified_date = Util::date_format_from_time(Util::start_of_month($date));
		$this->assertEqual( $modified_date, '2010-02-01'); 

		$date = '2010-12-31';
		$modified_date = Util::date_format_from_time(Util::start_of_month($date));
		$this->assertEqual( $modified_date, '2011-01-01'); 
	}

 
	function testCalculateBalanceWithDateRange(){
	#Company 
		$cp = new Company();
		$cp->set(array('name'=>'Test Company','status'=>'active'));
		$cp->save();
	
		$pb = new CompanyPreviousBalance();
		$pb->set(array( 'company_id'=>$cp->id, 'balance'=>600.25, 'date'=>'2010-01-30'));
		$pb->save();

		######### Support
		$sc = new SupportContract();
		$sc->set(array('company_id'=>$cp->id,'domain_name'=>'Test','start_date'=>'2010-01-01','end_date'=>'2010-04-30','hourly_rate'=>'120','support_hours'=>'.5','monthly_rate'=>'50'));
		$sc->save();
		# add support hours 
		# before previous balance
	    $h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-01-20','hours'=>'2.5'));
        $h->save();
		# in range 
		$h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-02-20','hours'=>'2.5'));
        $h->save();
		# in range
		$h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-03-20','hours'=>'2.5'));
        $h->save();
		# out of range
		$h = new Hour();
        $h->set(array('description'=>'Test','support_contract_id'=>$sc->id,'date'=>'2010-05-20','hours'=>'2'));
        $h->save();
		### Support Totals = in range is 2 months x 50 = 100, 4 @ 120 = 480 = 580
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateSupportTotal($date_range);
		$this->assertEqual($total, 580);
		

		###### Project
		$pj = new Project();
		$pj->set(array( 'name'=>'Test Project','company_id'=>$cp->id,'hourly_rate'=>'120' ));
		$pj->save();
		# Add an Estimate item #1
		$es1 = new Estimate();
		$es1->set(array('project_id'=>$pj->id,'name'=>'Test Estimate 1','high_hours'=>'10','low_hours'=>'5'));
		$es1->save();
		# Add an Estimate item #2
		$es2 = new Estimate();
		$es2->set(array('project_id'=>$pj->id,'name'=>'Test Estimate 2','high_hours'=>'10','low_hours'=>'5'));
		$es2->save();
		# Add some before previous balance hours for #1 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es1->id,'description'=>'Test Hours for Estimate 1','date'=>'2010-01-15','hours'=>'5'));
		$hr->save();
		# Add some in range hours for #1 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es1->id,'description'=>'Test Hours for Estimate 1','date'=>'2010-02-15','hours'=>'5'));
		$hr->save();
		# Add some in range hours for #2 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es2->id,'description'=>'Test Hours for Estimate 2','date'=>'2010-02-15','hours'=>'5'));
		$hr->save();
		# Add some out of range hours for #2 - 5 hours at 120 = 600	
		$hr = new Hour();	
		$hr->set(array('estimate_id'=>$es2->id,'description'=>'Test Hours for Estimate 2','date'=>'2010-05-15','hours'=>'5'));
		$hr->save();
		## Project Totals = In range 1200, out of range 1800 
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateProjectsTotal( $date_range );
		$this->assertEqual($total,1200);


		#Charge
		# before previous balance
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-01-10','amount'=>'20.50'));
		$cr->save();
		# in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-14','amount'=>'50.25'));
		$cr->save();
		# in date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-03-20','amount'=>'50'));
		$cr->save();
		# out of date range
        $cr = new Charge();
        $cr->set(array('name'=>'Test','company_id'=>$cp->id,'date'=>'2010-05-15','amount'=>'50'));
		$cr->save();

		# Total Charges = in range 100.25, out of range 150.25 
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$charge_total = $cp->calculateChargesTotal($date_range); 
		$this->assertEqual($charge_total, 100.25 );
	
		## Test Total Costs	
		# Charges 100.25 + project 1200 + support 580 	
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$total = $cp->calculateCosts( $date_range ); 
		$this->assertEqual($total, 1880.25);

		## Payments 
		# add payment before previous balance date
		$py = New Payment();	
		$py->set(array('company_id'=>$cp->id,'date'=>'2010-01-22','amount'=>'20.50'));
		$py->save();

		# add payment in range
		$py = New Payment();	
		$py->set(array('company_id'=>$cp->id,'date'=>'2010-02-10','amount'=>'20.00'));
		$py->save();

		# add payment in range
		$py = New Payment();	
		$py->set(array('company_id'=>$cp->id,'date'=>'2010-03-01','amount'=>'120.00'));
		$py->save();

		# add payment out of range
		$py = New Payment();	
		$py->set(array('company_id'=>$cp->id,'date'=>'2010-04-01','amount'=>'20.25'));
		$py->save();
		
		# Total Payments are 20 + 120 = 140 in range and after previous balance
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$payment_total = $cp->calculatePaymentsTotal($date_range); 
		$this->assertEqual($payment_total, 140 );
	
		#### fails because the previous balance isn't getting included FIX ME!! 
		# Total Balance Costs 1880.25 - Payments 140 + Previous balance 600.25 = 2340.5  
		$date_range = array( 'start_date'=>'2010-01-01', 'end_date'=>'2010-03-31');
		$balance = $cp->calculateBalance( $date_range );
		$this->assertWithinMargin( $balance, 2340.50, 0.001);

		## clean up
		$cp->destroyAssociatedRecords();
		$cp->delete();
	

	}

/*
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
