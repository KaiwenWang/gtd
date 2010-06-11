<?php

class AddDetailsToInvoiceTable extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('invoice','details','text');
	}//up()

	public function down() {
		$this->remove_column('invoice','details');
	}//down()
}
?>
