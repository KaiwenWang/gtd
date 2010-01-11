<?php

class CreateInvoiceStandardTable extends Ruckusing_BaseMigration {

	public function up() {
		$invoice = $this->create_table('invoice_standard');    
		$invoice->column('company_id','integer');
		$invoice->column('type','string');
		$invoice->column('start_date','date');
		$invoice->column('end_date','date');
		$invoice->column('pdf','text');
		$invoice->column('sent_date','date');
		$invoice->column('status','string');
		$invoice->column('previous_balance','float');
		$invoice->column('new_costs','float');
		$invoice->column('amount_due','float');
		$invoice->finish();
	}//up()

	public function down() {
    	$this->drop_table('invoice_standard');
	}//down()
}
?>
