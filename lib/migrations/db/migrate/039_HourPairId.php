<?php

class HourPairId extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('hour','pair_id','integer');

	}//up()

	public function down() {
		$this->remove_column('hour','pair_id');

	}//down()
}
?>
