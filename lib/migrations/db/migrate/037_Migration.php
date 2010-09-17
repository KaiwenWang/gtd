<?php

class Migration extends Ruckusing_BaseMigration {

	public function up() {
 		$this->rename_table("client", "client_user" );
	}//up()

	public function down() {
 		$this->rename_table("client_user", "client" );
	}//down()
}
?>
