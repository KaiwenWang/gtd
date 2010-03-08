<?php

class UpdateCompanyTable extends Ruckusing_BaseMigration {

	public function up() {
		$this->add_column('company','date_started','date');
		$this->add_column('company','date_ended','date');
		$this->remove_column('company','balance');
		$this->remove_column('company','product');
		$this->remove_column('company','stasi_id');
		$this->remove_column('company','phone');
		$this->remove_column('company','billing_phone');
		$this->remove_column('company','other_phone');
	}//up()

	public function down() {
		$this->remove_column('company','date_started');
		$this->remove_column('company','date_ended');
		$this->add_column('company','balance','float');
		$this->add_column('company','product','string');
		$this->add_column('company','stasi_id','integer');
		$this->add_column('company','phone','string');
		$this->add_column('company','billing_phone','string');
		$this->add_column('company','other_phone','string');
	}//down()
}
?>
