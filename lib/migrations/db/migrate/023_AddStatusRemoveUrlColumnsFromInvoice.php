<?php

class AddStatusRemoveUrlColumnsFromInvoice extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column("invoice","status","string");
		$this->remove_column("invoice","url");
	}//up()

	public function down() {
		$this->remove_column("invoice","status");
		$this->add_column("invoice","url","string");

	}//down()
}
?>
