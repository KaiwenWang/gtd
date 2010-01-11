<?php

class MergingInvoiceStandradIntoInvoice extends Ruckusing_BaseMigration {

	public function up() {
		$this->remove_column("invoice","project_id");
		$this->remove_column("invoice","support_contract_id");
		$this->remove_column("invoice","html");
		$this->remove_column("invoice","date");
		$this->add_column("invoice","previous_balance","float");
		$this->add_column("invoice","new_costs","float");
		$this->add_column("invoice","new_payments","float");
		$this->rename_column("invoice","amount","amount_due");

		$this->drop_table("invoice_standard");

	}//up()

	public function down() {
		$this->add_column("invoice","project_id");
		$this->add_column("invoice","support_contract_id");
		$this->add_column("invoice","html");
		$this->add_column("invoice","date");
		$this->remove_column("invoice","previous_balance","float");
		$this->remove_column("invoice","new_costs","float");
		$this->remove_column("invoice","new_payments","float");
		$this->rename_column("invoice","amount_due","amount");

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
		$invoice->column("new_payments", "float");	
		$invoice->column('amount_due','float');
		$invoice->finish();

	}//down()
}
?>
