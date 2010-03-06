<?php

class CreateStatusTable extends Ruckusing_BaseMigration {

	public function up() {
		$status = $this->create_table('status');
		$status->column('name', 'string');
		$status->column('type', 'string');
		$status->finish();
	}//up()

	public function down() {
    	$this->drop_table('status');
	}//down()
}
?>
