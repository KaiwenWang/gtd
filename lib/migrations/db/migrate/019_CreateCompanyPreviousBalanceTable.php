<?php

class CreateCompanyPreviousBalanceTable extends Ruckusing_BaseMigration {

	public function up() {
    $cpb = $this->create_table('company_previous_balance');
    $cpb->column('company_id','integer');
    $cpb->column('date','date');
    $cpb->column('amount','float');
    $cpb->finish();

	}//up()

	public function down() {
    $this->drop_table('company_previous_balance');
	}//down()
}
?>
