<?php

class AddUsernameAndPasswordToStaffTable extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('staff','username','string');
		$this->add_column('staff','password','string');
	}//up()

	public function down() {
		$this->remove_column('staff','username');
		$this->remove_column('staff','password');
	}//down()
}
?>
