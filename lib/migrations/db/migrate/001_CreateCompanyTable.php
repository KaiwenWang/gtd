<?php

class CreateCompanyTable extends Ruckusing_BaseMigration {

  public function up() {
    $company = $this->create_table('company');
    $company->column('name', 'string');
    $company->column('notes', 'text');
    $company->column('street', 'string');
    $company->column('street_2', 'string');
    $company->column('city', 'string');
    $company->column('state', 'string');
    $company->column('zip', 'integer');
    $company->column('phone', 'string');
    $company->column('other_phone', 'string');
    $company->column('billing_phone', 'string');
    $company->column('stasi_id', 'integer');
    $company->column('preamp_id', 'integer');
    $company->column('status', 'string');
    $company->column('bay_area', 'boolean');
    $company->column('product', 'string');
    $company->column('balance', 'float');
    $company->finish();

    //mapping old column names to new column names
    $columnNames = array(          
      'id'=>'id',
      'Company'=> "name" ,
      'Notes'=> "notes" ,
      'Street'=> "street" ,
      'Street_2'=> "street_2" ,
      'City'=> "city" ,
      'State'=> "state" ,
      'Zip'=> "zip" ,
      'Phone'=> "phone" ,
      'Cell_Phone'=> "other_phone" ,
      'Work_Phone'=> "billing_phone" ,
      'custom6'=> "stasi_id" ,
      'custom7'=> "preamp_id" ,
      'custom8'=> "status" ,
      'custom9'=> "product" ,
      'custom10'=> "bay_area" ,
      'custom11'=> "balance" ,
    );

    $sql = 'INSERT INTO `company` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=60;';


    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('company');
  //no down function because when the fuck would we ever roll back to one big table
  }

}
?>
