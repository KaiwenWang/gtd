<?php

class AddBillingStatusToCompany extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column("company", "billing_status", "string");
	}//up()

	public function down() {
    $this->remove_column("company", "billing_status");
	}//down()
}
?>
