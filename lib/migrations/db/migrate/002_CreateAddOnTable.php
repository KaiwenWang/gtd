<?php

class CreateAddOnTable extends Ruckusing_BaseMigration {

  public function up() {
    $a = $this->create_table('add_on');
    $a->column('support_contract_id', 'integer');
    $a->column('name', 'string');
    $a->column('amount', 'float');
    $a->column('description', 'text');
    $a->column('date', 'date');
    $a->column('invoice_id', 'integer');
    $a->finish();

    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom1'=>'support_contract_id',
      'custom2'=>'name',
      'custom3'=>'amount',
      'custom4'=>'description',
      'custom5'=>'date',
      'custom6'=>'invoice_id'
    );
    
    $sql = 'INSERT INTO `add_on` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=71;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('add_on');
  }//down()
}
?>
