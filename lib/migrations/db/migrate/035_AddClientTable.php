<?php

class AddClientTable extends Ruckusing_BaseMigration {

	public function up() {
		$t= $this->create_table('client');
		$t->column('first_name', 'string');
		$t->column('last_name', 'string');
		$t->column('email', 'string');
		$t->column('company_id', 'integer');
		$t->column('username', 'string');
		$t->column('password', 'string');
		$t->finish();
	}//up()

	public function down() {
		$this->drop_table('client');
	}//down()
}
?>
