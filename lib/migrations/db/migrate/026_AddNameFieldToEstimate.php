<?php

class AddNameFieldToEstimate extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('estimate','name','string');
	}//up()

	public function down() {
		$this->remove_column('estimate','name');
	}//down()
}
?>
