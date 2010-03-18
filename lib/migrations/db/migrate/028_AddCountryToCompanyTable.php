<?php

class AddCountryToCompanyTable extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('company','country','string');
	}//up()

	public function down() {
		$this->remove_column('company','country');
	}//down()
}
?>
