<?php

function productInstanceInfo($product_instance, $o = array()) {
  $r = getRenderer();
  $contract = new SupportContract($product_instance->getData('contract_id'));
  if(!$contract->hasData()) $contract = false;
  $company = new Company($product_instance->getData('company_id'));
  if(!$company->hasData()) $company = false;
  $list_items = array(
    'Domain Name' => $product_instance->getData('domain_name'),
    'Techonology' => $product_instance->getData('technology'),
    'DNS Notes' => $product_instance->getData('dns_notes'),
    'Other Domain Names' => $product_instance->getData('other_domain_names'),
    'Server' => $product_instance->getData('server'),
    'Subsites' => $product_instance->getData('subsites'),
    'Server Account' => $product_instance->getData('server_account'),
    'Apache File' => $product_instance->getData('apache_file'),
    'Wordpress' => $product_instance->getData('wordpress') ? 'yes' : false,
    'OS Commerce' => $product_instance->getData('oscom') ? 'yes' : false,
    'Drupal' => $product_instance->getData('drupal') ? 'yes' : false,
    'Secure HTTPS' => $product_instance->getData('secure_domain') ? 'yes' : false,
    'China IP' => $product_instance->getData('china_ip') ? 'yes' : false,
    'PHPlist' => $product_instance->getData('phplist') ? 'yes' : false,
    'Contract' => $contract ? $contract->getName() : false,
    'Company' => $company ? $company->getName() : false,
    'Notes' => $product_instance->getData('notes')
  );
  $empty_list_keys = array_keys($list_items, false);
  foreach($empty_list_keys as $key) {
    unset($list_items[$key]);
  }
  $product_instance_info = $r->view('basicList', $list_items);
  
  return $product_instance_info;
}

?>
