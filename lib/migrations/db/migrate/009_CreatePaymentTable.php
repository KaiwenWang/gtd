<?php

class CreatePaymentTable extends Ruckusing_BaseMigration {

  public function up() {
    //drop legacy payment table
    $t = $this->create_table('payment');
    $t->column('date', 'date');
    $t->column('amount', 'float');
    $t->column('type', 'string');
    $t->column('preamp_id', 'integer');
    $t->column('preamp_client_id', 'integer');
    $t->column('product', 'string');
    $t->column('invoice_id', 'integer');
    $t->column('company_id', 'integer');
    $t->column('notes', 'text');
    $t->finish();


    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom1'=>"date",
      'custom2'=>"amount",
      'custom3'=>"type",
      'custom4'=>"preamp_id",
      'custom5'=>"preamp_client_id",
      'custom6'=>"product",
      'custom7'=>"invoice_id",
      'Company'=>"company_id",
      'Notes'=>"notes",
    );
    
    $sql = 'INSERT INTO `payment` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=69;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('payment');
    //since this script will expect to drop a payment table we will create an empty one so the script doesn't shit the bed 
    $t = $this->create_table('payment');
    $t->finish(); 
  }//down()
}
?>
