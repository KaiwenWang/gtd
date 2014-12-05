<?php

class AddPurposeToPayment extends Ruckusing_BaseMigration {

  public function up() {
    $this->add_column("payment", "purpose", "string");
  }//up()

  public function down() {
    $this->remove_column("payment", "purpose");
  }//down()
}
?>
