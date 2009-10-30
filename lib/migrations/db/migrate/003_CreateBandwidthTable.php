<?php

class CreateBandwidthTable extends Ruckusing_BaseMigration {

  public function up() {
    $b = $this->create_table("bandwidth");
    $b->column('support_contract_id', 'integer');
    $b->column('gigs_over', 'float');
    $b->column('date', 'date');
    $b->finish();

    //mapping of old columns to new columns
    //
    //old => new
    $columnNames = array(
      'id'=>'id',
      'custom1'=>'support_contract_id',
      'custom2'=>'gigs_over',
      'custom3'=>'date'
    );
    
    $sql = 'INSERT INTO `bandwidth` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=70;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('bandwidth');
  }//down()
}
?>
