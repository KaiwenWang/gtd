<?php

class AddCompanyIdFieldToInvoice extends Ruckusing_BaseMigration {

	public function up() {
        $this->add_column("invoice", "company_id", "integer");
        $this->execute("UPDATE invoice i LEFT JOIN support_contract s on i.support_contract_id = s.id SET i.company_id = s.company_id WHERE i.support_contract_id");
        $this->execute("UPDATE invoice i LEFT JOIN project s on i.project_id = s.id SET i.company_id = s.company_id WHERE i.project_id");


	}//up()

	public function down() {
        $this->remove_column("invoice", "company_id");

	}//down()
}
?>
