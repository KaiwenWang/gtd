<?php

class CreateProductInstanceTable extends Ruckusing_BaseMigration {

  public function up() {
    $t = $this->create_table('product_instance');
    $t->column('domain_name',  'string');
    $t->column('technology',  'string');
    $t->column('dns_notes',  'text');
    $t->column('other_domain_names',  'text');
    $t->column('server',  'string');
    $t->column('subsites',  'text');
    $t->column('server_account',  'text');
    $t->column('apache_file',  'string');
    $t->column('contract_id',  'integer');
    $t->column('wordpress',  'boolean');
    $t->column('oscom',  'boolean');
    $t->column('drupal',  'boolean');
    $t->column('secure_domain',  'boolean');
    $t->column('china_ip',  'boolean');
    $t->column('phplist',  'boolean');
    $t->column('company_id',  'integer');
    $t->column('notes',  'text');
    $t->finish();


    //mapping old column names to new column names
    $columnNames = array(
      //old=>new
      'id'=>'id',
      'custom1'=>"domain_name",
      'custom2'=>"technology",
      'custom12'=>"dns_notes",
      'custom13'=>"other_domain_names",
      'custom14'=>"server",
      'custom15'=>"subsites",
      'custom17'=>"server_account",
      'custom18'=>"apache_file",
      'custom19'=>"contract_id",
      'custom20'=>"wordpress",
      'custom21'=>"oscom",
      'custom22'=>"drupal",
      'custom23'=>"secure_domain",
      'custom24'=>"china_ip",
      'custom25'=>"phplist",		
      'Company'=>"company_id",
      'Notes'=>"notes",
      );
	
    $sql = 'INSERT INTO `product_instance` ('. implode(', ', array_values($columnNames)) .' )';
    $sql .= ' SELECT '. implode(', ', array_keys($columnNames)) .' FROM `userdata` WHERE modin=68;';
    $this->execute($sql);
  }//up()

  public function down() {
    $this->drop_table('product_instance');
  }//down()
}
?>
