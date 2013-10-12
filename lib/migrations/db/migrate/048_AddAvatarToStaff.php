<?php

class AddAvatarToStaff extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column("staff", "avatar", "string");
	}//up()

	public function down() {
    $this->remove_column("staff", "avatar");
	}//down()
}
?>
