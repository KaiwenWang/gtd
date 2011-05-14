<?php

class ProjectInternalHour extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column('project','internal','boolean');
	}//up()

	public function down() {
    $this->remove_column('project','internal');
	}//down()
}
?>
