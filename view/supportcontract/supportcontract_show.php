<?php
function supportcontractShow($d){
    $r =& getRenderer();
    $contract_finder 	= $r->view( 'jumpSelect', 		$d->contract );
 
	$hidden_forms = $r->view('jsHideable', array(
  						'Create New Support Contract' => $r->view( 'supportcontractNewForm', 
  														  			$d->new_contract),
						'Log Support Hour' => $r->view( 'supporthourNewForm',
														$d->new_hour)
  							)
  						);

  	$contract_info = '
						<div class="detail-list float-left"> 
	 						'.$r->view( 'supportcontractInfo', $d->contract).'
						</div>
					';
    
    $hour_table 		= $r->view( 'supporthourTable', $d->contract->getHours( ));



	return array(
		'title' => $d->	contract->getName(),
		'controls' => $contract_finder,
		'body' 	=> 	$contract_info
					.$hidden_forms
					.$hour_table
		);
}
