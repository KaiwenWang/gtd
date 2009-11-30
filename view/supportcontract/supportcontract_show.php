<?php
function supportcontractShow($d){
    $r =& getRenderer();
    $contract_finder 	= $r->view( 'jumpSelect', 		$d->contract );
 
	$hidden_forms = $r->view('jsHideable', array(
  						'Create New Support Contract' => $r->view( 'supportcontractNewForm', 
  														  			$d->new_contract),
						'Log Support Hour' => $r->view( 'hourSupportNewForm',
														$d->new_hour)
  							)
  						);

   
	$editable_contract_info= $r->view(	'jsSwappable',
										'Contract Info',
			 					array(
				 					$r->view( 'supportcontractInfo', $d->contract),
									$r->view( 'supportcontractEditForm', $d->contract)
								)
							);
    
    $hour_table 		= $r->view( 'hourTable', 		$d->contract->getHours( ));



	return array(
		'title' => $d->	contract->getName(),
		'controls' => $contract_finder,
		'body' 	=> 	$editable_contract_info
					.$hidden_forms
					.$hour_table
		);
}
