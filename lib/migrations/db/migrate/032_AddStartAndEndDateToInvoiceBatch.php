<?php

class AddStartAndEndDateToInvoiceBatch extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('invoice_batch','start_date','date');
		$this->add_column('invoice_batch','end_date','date');
		$this->rename_column('invoice_batch','date','created_date');
	}//up()

	public function down() {
		$this->remove_column('invoice_batch','start_date');
		$this->remove_column('invoice_batch','end_date');
		$this->rename_column('invoice_batch','created_date','date');

	}//down()
}
?>
