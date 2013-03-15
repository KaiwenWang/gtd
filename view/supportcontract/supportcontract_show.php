<?php
function supportcontractShow($d){
  $r =& getRenderer();
  $contract_finder  = $r->view( 'jumpSelect',     $d->contract );
 
  $hidden_forms = $r->view('jsMultipleButtons', 
                    array(
                      'Log Support Hour' => $r->view( 'supporthourNewForm', $d->new_hour),
                      'Add Charge' => $r->view( 'chargeNewForm', $d->new_charge )
                    )
                  );

  $contract_info = '
    <div class="bs-docs-example float-left" id="ContractInfo"> 
      '.$r->view( 'supportcontractInfo', $d->contract).'
    </div>
  ';

  $total_hours_this_month = '<h3>Total Hours This Month: '.$d->total_hours_this_month.'</h3>';
  $billable_hours_this_month = '<h3>Billable Hours This Month: '.$d->billable_hours_this_month.'</h3>';

  $d->hours ? $hours_table = $r->view('supporthourTable', $d->hours)
            : $hours_table = '
                <div class="empty-table-message">
                  No hours have been logged against this contract in this period.
                </div>
                ';

  return array(
    'title' => 'Support Contract: '.$d->contract->getShortName(),
    'controls' => $contract_finder,
    'body'  =>  $contract_info
                .$hidden_forms
                .$total_hours_this_month
                .$billable_hours_this_month
                .$hours_table
    );
}
