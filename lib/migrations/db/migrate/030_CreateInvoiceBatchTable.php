<?php

class CreateInvoiceBatchTable extends Ruckusing_BaseMigration {

	public function up() {
    	$batch = $this->create_table('invoice_batch');
    	$batch->column('name', 'string');
    	$batch->column('date', 'date');
		$batch->finish();
	}//up()

	public function down() {
    	$this->drop_table('batch_id');
	}//down()
}
?>
