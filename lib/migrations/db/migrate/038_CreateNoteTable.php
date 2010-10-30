<?php

class CreateNoteTable extends Ruckusing_BaseMigration {

	public function up() {
    $t = $this->create_table('note');
    $t->column('company_id', 'integer');
    $t->column('name', 'string');
    $t->column('description', 'text');
    $t->column('staff_id', 'integer');
    $t->column('date', 'date');
    $t->finish();
 
	}//up()

	public function down() {
    $this->drop_table('note');
	}//down()
}
?>
