<?php

class CreateInvoiceItemTable extends Ruckusing_BaseMigration {

  public function up() {
    $t = $this->create_table('invoice_item');
    $t->column('invoice_id', 'integer');
    $t->column('name', 'string');
    $t->column('description', 'text');
    $t->column('amount', 'float');
    $t->column('date', 'date');
    $t->column('type', 'text');
    $t->finish();
    //73
    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom1'=>"invoice_id",
      'custom2'=>"name",
      'custom3'=>"description",
      'custom4'=>"amount",
      'custom5'=>"date",
      'custom6'=>"type",
    );

    $sql = 'INSERT INTO `invoice_item` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=73;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('invoice_item');
  }//down()
}
?>
