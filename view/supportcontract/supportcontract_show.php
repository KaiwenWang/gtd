<?php
function supportcontractShow($d){
    $r =& getRenderer();
    $contract_finder 	= $r->view( 'jumpSelect', 		$d->contract );
    
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
					.$hour_table
		);
}