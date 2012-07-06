<?php

class AddActiveColumnToStaff extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column("staff", "active", "boolean", array('null' => false, 'default' => true));
	}//up()

	public function down() {
    $this->remove_column("staff", "active");
	}//down()
}
?>
