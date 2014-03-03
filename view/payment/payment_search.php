<?php 

function paymentSearch($payments, $o) {
  $r = getRenderer();

  $type = isset($o['type']) ? $o['type'] : '';
  $company_id = isset($o['company_id']) ? $o['company_id'] : '';
  $start_date = isset($o['date_range']['start_date']) ? $o['date_range']['start_date'] : '';
  $end_date = isset($o['date_range']['end_date']) ? $o['date_range']['end_date'] : '';

  $form = new Form(array(
    'controller' => 'Payment',
    'action' => 'search',
    'method' => 'get',
    'auto_submit' => array('company_id', 'payment_type', 'start_date', 'end_date'),
    'ajax_target_id' => 'payments-table'
  ));

  isset($o['search_payment']) ? $payment = $o['search_payment']
        : $payment = new Payment(); 
  $fs = $form->getFieldSetFor($payment);
  $form->content = $fs->field('payment_type',array('title' => 'Payment Type'));
  $form->content .= $fs->field('company_id',array('title' => 'Client'));

  $form->content .= '<div class="search-input">
      <label for="payment_search_start">Start Date</label>
      ' . $r->input('date', array(
        'name' => 'date_range[start_date]',
        'value' => $start_date,
        'id' => 'payment_search_start'
      )) . '
    </div>
    <div class="search-input">
      <label for="payment_search_end">End Date</label>
      ' . $r->input('date', array(
        'name' => 'date_range[end_date]',
        'value' => $end_date,
        'id' => 'payment_search_end'
      )) . '
    </div>
    ';
 
  $o['search'] = $form->html;

  return  $r->view('paymentTable', $payments, $o);
}

?>
