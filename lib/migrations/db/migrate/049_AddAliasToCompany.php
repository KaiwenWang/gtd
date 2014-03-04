<?php

class AddAvatarToStaff extends Ruckusing_BaseMigration {

  public function up() {
    $this->add_column("company", "alias", "string");
  }//up()

  public function down() {
    $this->remove_column("company", "alias");
  }//down()
}
?>
