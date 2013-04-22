<?php

class AddPaymentStatusToInvoice extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column("invoice", "payment_status", "string");
	}//up()

	public function down() {
    $this->remove_column("invoice", "payment_status");
	}//down()
}
?>
