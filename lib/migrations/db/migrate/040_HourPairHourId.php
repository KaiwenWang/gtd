<?php

class HourPairHourId extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('hour','pair_hour_id','integer');

	}//up()

	public function down() {
		$this->remove_column('hour','pair_hour_id');

	}//down()
}
?>
