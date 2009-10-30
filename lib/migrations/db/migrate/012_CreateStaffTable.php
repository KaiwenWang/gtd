<?php

class CreateStaffTable extends Ruckusing_BaseMigration {

  public function up() {
    $t= $this->create_table('staff');
    $t->column('first_name', 'string');
    $t->column('last_name', 'string');
    $t->column('email', 'string');
    $t->column('basecamp_id', 'integer');
    $t->column('team', 'string');
    $t->finish();

    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'First_Name' => 'first_name',
      'Last_Name' => 'last_name',
      'Email' => 'email',
      'custom1' => 'basecamp_id',
      'custom2' => 'team',
    );

    $sql = 'INSERT INTO `staff` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=65;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('staff');
  }//down()
}
?>
