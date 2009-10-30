<?php

class CreateInvoiceTable extends Ruckusing_BaseMigration {

  public function up() {
    $t = $this->create_table('invoice');
    $t->column('support_contract_id', 'integer');
    $t->column('project_id', 'integer');
    $t->column('type', 'string');
    $t->column('start_date', 'date');
    $t->column('end_date', 'date');
    $t->column('pdf', 'string');
    $t->column('url', 'string');
    $t->column('html', 'text');
    $t->column('sent_date', 'date');
    $t->column('date', 'date');
    $t->column('amount', 'float');
    $t->finish();
    
    //72
    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom1'=>"support_contract_id",
      'custom2'=>"project_id",
      'custom3'=>"type",
      'custom4'=>"start_date",
      'custom5'=>"end_date",
      'custom6'=>"pdf",
      'custom7'=>"url",
      'custom8'=>"html",
      'custom9'=>"sent_date",
      'custom10'=>"date",
      'custom11'=>"amount"	
    );

    $sql = 'INSERT INTO `invoice` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=72;';
    $this->execute($sql);
              
  }//up()

  public function down() {
    $this->drop_table('invoice');
  }//down()
}
?>
