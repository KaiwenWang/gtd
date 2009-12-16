<?php

class RenameAddonsAndConnectToCompanies extends Ruckusing_BaseMigration {

    public function up() {
 		$this->add_column("add_on", "company_id", "integer");	
 		$this->rename_table("add_on", "charge" );
        $this->execute( "UPDATE charge a left join support_contract b on a.support_contract_id = b.id set a.company_id = b.company_id" );

    }//up()

    public function down() {
 		$this->remove_column("add_on", "company_id");	
 		$this->rename_table("charge", "add_on" );

    }//down()
}
?>
