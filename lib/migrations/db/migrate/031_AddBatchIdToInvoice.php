<?php

class AddBatchIdToInvoice extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('invoice','batch_id','integer');
	}//up()

	public function down() {
		$this->remove_column('invoice','batch_id');
	}//down()
}
?>
