<?php

class CreateSupportContractTable extends Ruckusing_BaseMigration {

  public function up() {
    $t= $this->create_table('support_contract');
    $t->column('company_id', 'integer');
    $t->column('domain_name', 'string');
    $t->column('technology', 'string');
    $t->column('monthly_rate', 'float');
    $t->column('support_hours', 'float');
    $t->column('hourly_rate', 'float');
    $t->column('pro_bono', 'boolean');
    $t->column('contract_on_file', 'boolean');
    $t->column('no_contract_on_file', 'boolean');
    $t->column('status', 'string');
    $t->column('not_monthly', 'boolean');
    $t->column('start_date', 'date');
    $t->column('end_date', 'date');
    $t->column('notes', 'text');
    $t->column('contract_url', 'string');
    $t->finish();

    //67
    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'Company'=>"company_id",
      'custom1'=>"domain_name",
      'custom2'=>"technology",
      'custom3'=>"monthly_rate",
      'custom4'=>"support_hours",
      'custom5'=>"hourly_rate",
      'custom6'=>"pro_bono",
      'custom7'=>"contract_on_file",
      'custom8'=>"status",
      'custom9'=>"not_monthly",
      'custom10'=>"start_date",
      'custom11'=>"end_date",
      'custom12'=>"notes",
      'custom19'=>"no_contract_on_file",
      'custom20'=>"contract_url",
    );
    
    $sql = 'INSERT INTO `support_contract` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=67;';
    $this->execute($sql);

  }//up()

  public function down() {
    $this->drop_table('support_contract');
  }//down()
}
?>
