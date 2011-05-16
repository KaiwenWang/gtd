<?php

class AddPermalinkToStaff extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column("staff", "permalink", "string");
	}//up()

	public function down() {
    $this->remove_column("staff", "permalink");
	}//down()
}
?>
