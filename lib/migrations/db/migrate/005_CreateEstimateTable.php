<?php

class CreateEstimateTable extends Ruckusing_BaseMigration {

  public function up() {
    $e = $this->create_table('estimate');
    $e->column('project_id','integer');
    $e->column('description','text');
    $e->column('high_hours','float');
    $e->column('due_date','date');
    $e->column('completed','boolean');
    $e->column('notes','text');
    $e->column('low_hours','float');
    $e->column('basecamp_id','integer');
    $e->finish();

    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom1'=> "project_id",
      'custom2'=> "description",
      'custom3'=> "high_hours",
      'custom4'=> "due_date",
      'custom5'=> "completed",
      'custom6'=> "notes",
      'custom7'=> "low_hours",
      'custom8'=> "basecamp_id",
    );
    
    $sql = 'INSERT INTO `estimate` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=63;';
    $this->execute($sql);

  }//up()
  
  public function down() {
    $this->drop_table('estimate');
  }//down()
}
?>
