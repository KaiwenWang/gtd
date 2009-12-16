<?php

class ChangingTypeToPaymentTypeAndAddingCheckNumbers extends Ruckusing_BaseMigration {

	public function up() {
        $this->rename_column( 'payment', 'type', 'payment_type' );
        $this->add_column( 'payment', 'check_number', 'string' );
	}//up()

	public function down() {
        $this->rename_column( 'payment', 'payment_type', 'type' );
        $this->remove_column( 'payment', 'check_number' );

	}//down()
}
?>
