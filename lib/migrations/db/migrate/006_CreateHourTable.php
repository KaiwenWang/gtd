<?php

class CreateHourTable extends Ruckusing_BaseMigration {

  public function up() {
    $t = $this->create_table('hour');
    $t->column('estimate_id', 'integer');
    $t->column('support_contract_id', 'integer');
    $t->column('staff_id', 'integer');
    $t->column('description', 'string');
    $t->column('date', 'date');
    $t->column('hours', 'float');
    $t->column('discount', 'float');
    $t->column('basecamp_id', 'integer');
    $t->finish();

    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom2'=> "estimate_id",
      'custom3'=> "description",
      'custom4'=> "staff_id",
      'custom5'=> "date",
      'custom6'=> "hours",
      'custom7'=> "support_contract_id",
      'custom10'=> "discount",
      'custom11'=> "basecamp_id",
    );
    
    $sql = 'INSERT INTO `hour` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=62;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('hour');
  }//down()
}
?>
