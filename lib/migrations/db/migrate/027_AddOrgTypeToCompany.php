<?php

class AddOrgTypeToCompany extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('company','org_type','string');
	}//up()

	public function down() {
		$this->remove_column('company','org_type');
	}//down()
}
?>
