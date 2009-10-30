<?php

class CreateContactTable extends Ruckusing_BaseMigration {

  public function up() {
    $c = $this->create_table('contact');
    $c->column('first_name', 'string');
    $c->column('last_name', 'string');
    $c->column('company_id', 'integer');
    $c->column('title', 'string');
    $c->column('notes', 'text');
    $c->column('email', 'string');
    $c->column('phone', 'string');
    $c->column('fax', 'string');
    $c->column('street', 'string');
    $c->column('street_2', 'string');
    $c->column('city', 'string');
    $c->column('state', 'string');
    $c->column('zip', 'integer');
    $c->column('is_billing_contact', 'boolean');
    $c->column('is_primary_contact', 'boolean');
    $c->column('is_technical_contact', 'boolean');
    $c->column('preamp_id', 'integer');
    $c->column('stasi_id', 'integer');
    $c->column('stasi_project_id', 'integer');
    $c->column('help_id', 'integer');
    $c->finish();


    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'First_Name'=> "first_name",
      'Last_Name'=> "last_name",
      'Company'=> "company_id",
      'occupation'=> "title",
      'Notes'=> "notes",
      'Email'=> "email",
      'Phone'=> "phone",
      'Work_Fax'=> "fax",
      'Street'=> "street",
      'Street_2'=> "street_2",
      'City'=> "city",
      'State'=> "state",
      'Zip'=> "zip",
      'custom2'=> "is_billing_contact",
      'custom3'=> "is_primary_contact",
      'custom4'=> "is_technical_contact",
      'custom5'=> "preamp_id",
      'custom6'=> "stasi_id",
      'custom7'=> "stasi_project_id",
      'custom8'=> "help_id",
    );
    
    $sql = 'INSERT INTO `contact` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=61;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('contact');
  }//down()
}
?>
