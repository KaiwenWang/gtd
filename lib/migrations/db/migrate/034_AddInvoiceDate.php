<?php

class AddInvoiceDate extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('invoice','date','date');
	}//up()

	public function down() {
		$this->remove_column('invoice','date');
	}//down()
}
?>
