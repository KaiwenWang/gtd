<?php

class AddPreviousAndReplacementContractIds extends Ruckusing_BaseMigration {

	public function up() {
 		$this->add_column("support_contract", "replacement_contract_id", "integer");	
 		$this->add_column("support_contract", "previous_contract_id", "integer");	

	}//up()

	public function down() {
		$this->remove_column("support_contract", "replacement_contract_id", "integer");	
 		$this->remove_column("support_contract", "previous_contract_id", "integer");	

	}//down()
}
?>
