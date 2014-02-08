<?php

function companyKneecapsTable($companies, $o = array()) {
  $r = getRenderer();

  $search_form = '';
  if(!empty($o['search_company']) && is_a($o['search_company'], 'Company')) {
    $form = new Form(array(
      'controller' => 'Company',
      'action' => 'kneecaps',
      'method' => 'get',
      'auto_submit' => array('status'),
    ));
    $f = $form->getFieldSetFor($o['search_company']);
    $form_content = $f->field('status', array('title' => 'Status'));
    $form->content = $form_content; 
    $search_form = $form->html;
  }
  
  $table = array();
  $table['headers'] = array('Client', 'Billing Name', 'Billing Email', 'Billing Phone', ' Status', 'Last Payment', 'Billing Status', 'Balance');
  $table['rows'] =  array();

  foreach($companies as $c) {
    $link = $r->link('Company', array('action' => 'show', 'id' => $c->id), $c->getName());
    $contact_link = $r->link('Contact', array('action' => 'show', 'id' => $c->getBillingContact()->id), $c->getBillingContactName());
    $contact_email = '<a href="mailto:' . $c->getBillingEmailAddress() . '">' . $c->getBillingEmailAddress() . '</a>';
    $contact_phone = $c->getBillingPhone();

    $table['rows'][] = array(
      $link, 
      $contact_link, 
      $contact_email,
      $contact_phone,
      $c->get('status'), 
      $c->getLastPaymentDate(), 
      $c->get('billing_status'),
      $c->calculateBalance(array('end_date' => Util::date_format_from_time())) 
    );
  }

  return $r->view('basicTable', $table, array('title' => 'Search Clients', 'search' => $search_form, 'pager' => true));
}

?>
