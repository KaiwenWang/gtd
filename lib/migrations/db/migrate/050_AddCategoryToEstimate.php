<?php

class AddCategoryToEstimate extends Ruckusing_BaseMigration {

  public function up() {
    $this->add_column("estimate", "category", "string");
  }//up()

  public function down() {
    $this->remove_column("estimate", "category");
  }//down()
}
?>
