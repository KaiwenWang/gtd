<?php

class CreateProjectTable extends Ruckusing_BaseMigration {

  public function up() {
    $t = $this->create_table('project'); 
    $t->column('name', 'string');
    $t->column('amp_url', 'string');
    $t->column('design_date', 'date');
    $t->column('desinger', 'string');
    $t->column('launch_date', 'date');
    $t->column('discovery_date', 'date');
    $t->column('crm_notes', 'text');
    $t->column('udm_notes', 'text');
    $t->column('content_notes', 'text');
    $t->column('custom_notes', 'text');
    $t->column('training_notes', 'text');
    $t->column('email_notes', 'text');
    $t->column('domain_notes', 'text');
    $t->column('contract_notes', 'text');
    $t->column('other_notes', 'text');
    $t->column('status', 'string');
    $t->column('deposit', 'float');
    $t->column('contract_url', 'string');
    $t->column('deposit_date', 'date');
    $t->column('other_contacts', 'text');
    $t->column('basecamp_id', 'integer');
    $t->column('final_payment', 'float');
    $t->column('final_payment_date', 'date');
    $t->column('cost', 'float');
    $t->column('priority', 'string');
    $t->column('real_launch_date', 'date');
    $t->column('real_design_date', 'date');
    $t->column('hour_cap', 'float');
    $t->column('staff_id', 'integer');
    $t->column('company_id', 'integer');
    $t->column('hourly_rate', 'float');
    $t->column('hours_high', 'float');
    $t->column('billing_status', 'string');
    $t->column('main_payment', 'float');
    $t->column('main_payment_date', 'date');
    $t->column('billing_type', 'string');
    $t->column('hours_low', 'float');
    $t->finish();

    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'Company'=>"name",
      'custom1'=>"amp_url",
      'custom2'=>"design_date",
      'custom3'=>"desinger",
      'custom4'=>"launch_date",
      'custom5'=>"discovery_date",
      'custom6'=>"crm_notes",
      'custom7'=>"udm_notes",
      'custom8'=>"content_notes",
      'custom9'=>"custom_notes",
      'custom10'=>"training_notes",
      'custom11'=>"email_notes",
      'custom12'=>"domain_notes",
      'custom15'=>"contract_notes",
      'custom16'=>"other_notes",
      'custom17'=>"status",
      'custom18'=>"deposit",
      'custom19'=>"contract_url",
      'custom20'=>"deposit_date",
      'custom21'=>"other_contacts",
      'custom22'=>"basecamp_id",
      'custom23'=>"final_payment",
      'custom24'=>"final_payment_date",
      'custom26'=>"cost",
      'custom27'=>"priority",
      'custom28'=>"real_launch_date",
      'custom29'=>"real_design_date",
      'custom30'=>"hour_cap",
      'custom31'=>"staff_id",
      'custom32'=>"company_id",
      'custom33'=>"hourly_rate",
      'custom34'=>"hours_high",
      'custom35'=>"billing_status",
      'custom36'=>"main_payment",
      'custom37'=>"main_payment_date",
      'custom38'=>"billing_type",
      'custom39'=>"hours_low",
    );
		
    $sql = 'INSERT INTO `project` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=54;';
    $this->execute($sql);
  }//up()

  public function down() {
    drop_table('project_table');
  }//down()
}
?>
