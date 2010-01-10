<?php
class testBilling extends UnitTestCase {
	function testActiveMonths(){
		$date_range = array('end_date'=>'2010-08-15');
		$months = $this->sc1->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 16);
		
		$months = $this->sc_no_end_date->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 6);
	}
	function testActiveMonthsWithStartDate(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$months = $this->sc1->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 14);
		
		$months = $this->sc_no_end_date->activeMonths($date_range);
		$number_of_months = count($months);
		$this->assertEqual( $number_of_months, 6);
	}
	function testCalculateOneSupportContractTotal(){
		$date_range = array('end_date'=>'2010-08-15');
		$sc1_total = $this->sc1->calculateTotal($date_range);
		$this->assertEqual( $sc1_total, 2325);
		$sc_no_end_date_total = $this->sc_no_end_date->calculateTotal($date_range);
		$this->assertEqual( $sc_no_end_date_total, 550);
	}
	function testCalculateOneSupportContractTotalWithStartDate(){
		$date_range = array( 'start_date'=>'2009-03-01', 'end_date'=>'2010-08-15');
		$sc1_total = $this->sc1->calculateTotal($date_range);
		$this->assertEqual( $sc1_total, 1275);
		$sc_no_end_date_total = $this->sc_no_end_date->calculateTotal($date_range);
		$this->assertEqual( $sc_no_end_date_total, 550);
	}
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
    function setUp() {
		/* Billing Test Correct Answers:
			
			Privous Balance Date: 2009-03-01
			End Date we are using: 2010-08-15

			SC1 contract length since previous balance: 13.5 months
			SC1 contract total ammount owed: 775(monthly rate) + 1550(hours minus monthly freebie) = $2325 

			SC1 contract ammount owed from Prev. Balance to End Date: 675(monthly rate) + 600(hours minus monthly freebie) = $1275 

			SC_no_end_date contract length since previous balance: 6 months
			SC_no_end_date contract ammount owed: 300(monthly rate) + 250(hours minus monthly freebie) = $ 550 
			
			Company Support Total = $ 2125

			Charges in Range = $ 55.22
			All charges = $ 95.44
			Billable Project Hours in Range = $ 500

			Payments (which are always in range) = $ 650.50 

			Company Balance: $ 2454.72 
			
			support_hour4 $250 + project_hour1 $100 + sc1 $250 + support_contract $50 = $ 650 is Calculate Costs
			
			(Costs = $2380.22 Payments = $650.50 Previous Balance = 600) =  BalanceWithDateRange = $2329.72
	
			(Costs = $650 Payments = $150.50 Previous Balance = 600.22) = BalanceWithStartDateBeforePreviousBalance = $1099.72
		*/
		$this->company = new Company();
		$this->company->set(array(
								'name'=>'Billing Test'
								)
							);
		$this->company->save();

		$this->previous_balance = new CompanyPreviousBalance();
		$this->previous_balance->set( array(
										'company_id'=>$this->company->id,
										'date'=>'2009-03-01',
										'amount'=>600
										)
									);
		$this->previous_balance->save();

		$this->old_previous_balance = new CompanyPreviousBalance();
		$this->old_previous_balance->set( array(
										'company_id'=>$this->company->id,
										'date'=>'2009-01-01',
										'amount'=>10000000000
										)
									);
		$this->old_previous_balance->save();


		$this->sc1 = new SupportContract();
		$this->sc1->set(array(
							'company_id'=>$this->company->id,
							'hourly_rate'=> 100,
							'monthly_rate'=> 50,
							'support_hours'=>.5,
							'start_date'=> '2009-01-04',
							'end_date'=>'2010-04-15'	
							)
						);
		$this->sc1->save();

		$this->old_support_hour = new Hour();	
		$this->old_support_hour->set(array(
							'support_contract_id'=>$this->sc1->id,
							'hours'=> 10,
							'date'=> '2009-01-15'
								)
						);
		$this->old_support_hour->save();

		$this->support_hour = new Hour();	
		$this->support_hour->set(array(
							'support_contract_id'=>$this->sc1->id,
							'hours'=> 4,
							'date'=> '2010-01-22'
								)
						);
		$this->support_hour->save();
	
		$this->support_hour1 = new Hour();	
		$this->support_hour1->set(array(
							'support_contract_id'=>$this->sc1->id,
							'hours'=> 3,
							'date'=> '2010-03-20'
								)
						);
		$this->support_hour1->save();

		$this->support_hour_invalid_date = new Hour();	
		$this->support_hour_invalid_date->set(array(
							'support_contract_id'=>$this->sc1->id,
							'hours'=> 7,
							'date'=> '2010-05-20'
								)
						);
		$this->support_hour_invalid_date->save();
		
		$this->sc_no_end_date = new SupportContract();
		$this->sc_no_end_date->set(array(
							'company_id'=>$this->company->id,
							'hourly_rate'=> 100,
							'monthly_rate'=> 50,
							'support_hours'=>.5,
							'start_date'=> '2010-03-01',
							)
						);
		$this->sc_no_end_date->save();

		$this->support_hour3 = new Hour();	
		$this->support_hour3->set(array(
							'support_contract_id'=>$this->sc_no_end_date->id,
							'hours'=> .25,
							'date'=> '2010-04-22'
								)
						);
		$this->support_hour3->save();

		$this->support_hour4 = new Hour();	
		$this->support_hour4->set(array(
							'support_contract_id'=>$this->sc_no_end_date->id,
							'hours'=> 3,
							'date'=> '2010-03-22'
							)
						);
		$this->support_hour4->save();

		$this->out_of_range_support_hour = new Hour();	
		$this->out_of_range_support_hour->set(array(
							'support_contract_id'=>$this->sc_no_end_date->id,
							'hours'=> 3,
							'date'=> '2010-10-22'
								)
						);
		$this->out_of_range_support_hour->save();
	
		$this->charge = new Charge();
		$this->charge->set( array(
							'company_id'=>$this->company->id,
							'amount'=>30,
							'date'=>'2010-02-15'
							)
						);
		$this->charge->save();

		$this->charge1 = new Charge();
		$this->charge1->set( array(
							'company_id'=>$this->company->id,
							'amount'=>25.22,
							'date'=>'2010-01-05'
							)
						);
		$this->charge1->save();

		$this->out_of_range_charge = new Charge();
		$this->out_of_range_charge->set( array(
							'company_id'=>$this->company->id,
							'amount'=>35.22,
							'date'=>'2010-08-25'
							)
						);
		$this->out_of_range_charge->save();

		$this->old_range_charge = new Charge();
		$this->old_range_charge->set( array(
							'company_id'=>$this->company->id,
							'amount'=>5,
							'date'=>'2009-02-25'
							)
						);
		$this->old_range_charge->save();


		$this->project = new Project();
		$this->project->set( array (
							'company_id'=>$this->company->id,
							'hourly_rate'=>100
							)
					);
		$this->project->save();
		$this->estimate = new Estimate();
		$this->estimate->set( array(
							'project_id'=>$this->project->id
							)
					);
		$this->estimate->save();
		$this->project_hour = new Hour();
		$this->project_hour->set( array(
								'estimate_id'=>$this->estimate->id,
								'hours'=> 6,
								'discount'=> 2,
								'date'=> '2010-02-21'
								)
							);
		$this->project_hour->save();

		$this->project_old_hour = new Hour();
		$this->project_old_hour->set( array(
								'estimate_id'=>$this->estimate->id,
								'hours'=> 20,
								'date'=> '2009-02-21'
								)
							);
		$this->project_old_hour->save();

		$this->project_hour1 = new Hour();
		$this->project_hour1->set( array(
								'estimate_id'=>$this->estimate->id,
								'hours'=> 1,
								'date'=> '2010-05-21'
								)
							);
		$this->project_hour1->save();


		$this->out_of_range_project_hour = new Hour();
		$this->out_of_range_project_hour->set( array(
								'estimate_id'=>$this->estimate->id,
								'hours'=> 1,
								'date'=> '2010-09-21'
								)
							);
		$this->out_of_range_project_hour->save();


		$this->payment = new Payment();
		$this->payment->set( array(
								'company_id'=>$this->company->id,
								'amount'=>500,
								'date'=>'2010-02-20'
								)
							);
		$this->payment->save();

		$this->payment1 = new Payment();
		$this->payment1->set( array(
								'company_id'=>$this->company->id,
								'amount'=>150.50,
								'date'=>'2010-08-01'
								)
							);
		$this->payment1->save();

		$this->out_of_range_payment = new Payment();
		$this->out_of_range_payment->set( array(
										'company_id'=>$this->company->id,
										'amount'=>300.50,
										'date'=>'2010-09-20'
										)
									);
		$this->out_of_range_payment->save();

		$this->old_payment = new Payment();
		$this->old_payment->set( array(
								'company_id'=>$this->company->id,
								'amount'=>300.50,
								'date'=>'2009-01-20'
								)
							);
		$this->old_payment->save();

	}
	function tearDown(){
		$this->company->destroyAssociatedRecords();
		$this->company->delete();
	}
}
