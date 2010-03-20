<?php

class AddTypeToCharges extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('charge','type','string');
	}//up()

	public function down() {
		$this->remove_column('charge','type');
	}//down()
}
?>
