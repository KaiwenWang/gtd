<?php

class AddNewPaymentsFieldToInvoiceStandard extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column("invoice_standard", "new_payments", "float");	
	}//up()

	public function down() {
		$this->remove_column("invoice_standard", "new_payments", "float");	
	}//down()
}
?>
