<?php

class HourPairName extends Ruckusing_BaseMigration {

	public function up() {
    $this->add_column('hour','pair_name','string');
	}//up()

	public function down() {
    $this->remove_column('hour','pair_name');
	}//down()
}
?>
