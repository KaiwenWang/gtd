<?php

function supportcontractInfo($contract, $options) {
  $r = getRenderer();
  $list_items = array(
    'Company' => $r->link('Company', array('action' => 'show', 'id' => $contract->get('company_id')), $contract->getCompanyName()),
    'Domain Name' => $contract->getData('domain_name'),
    'Tech' => $contract->getData('technology'),
    'Support Hours' => $contract->getData('support_hours'),
    'Hourly Rate' => $contract->getData('hourly_rate'),
    'Monthly Rate' => $contract->getData('monthly_rate'),
    'Pro Bono' => $contract->getData('pro_bono'),
    'Contract On File' => $contract->getData('contract_on_file'),
    'Status' => $contract->getData('status'),
    'Not Monthly' => $contract->getData('not_monthly'),
    'Notes' => $contract->getData('notes'),
    'Start Date' => $contract->getData('start_date'),
    'End Date' => $contract->getData('end_date'),
    'Contract Url' => $contract->getData('contract_url'),
    'Total Hours' => $contract->getTotalHours(),
    'Billable Hours' => $contract->getBillableHours()
  );

  $contract_info = $r->view('basicList', $list_items)
    . $r->link('SupportContract', 
      array(
        'action' => 'correct_mistake', 
        'id' => $contract->id
      ), 
      'Correct Mistake', 
      array(
        'id' => 'correct-mistake-contract-btn', 
        'class' => 'deter-btn'
      )
    );
  
  if ($contract->get('status') == SUPPORT_CONTRACT_STATUS_ACTIVE) {
    $contract_info.= $r->link('SupportContract', 
      array('action' => 'renew', 'id' => $contract->id), 
      'Update Contract', 
      array('id' => 'update-contract-btn', 'class' => 'standard-btn')
    ) . $r->link('SupportContract', 
      array('action' => 'cancel', 'id' => $contract->id),
      'Cancel Contract', 
      array('id' => 'cancel-contract-btn', 'class' => 'standard-btn')
    );
  }

  return $contract_info;
}

?>
