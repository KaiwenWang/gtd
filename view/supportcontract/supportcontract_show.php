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
    <div class="detail-list float-left"> 
      '.$r->view( 'supportcontractInfo', $d->contract).'
    </div>
  ';
    
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
                .$hours_table
    );
}
