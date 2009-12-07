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

  	$contract_info = '
						<div class="detail-list float-left"> 
	 						'.$r->view( 'supportcontractInfo', $d->contract).'
							'.$r->link( 'SupportContract', 
										array( 'action'=>'correct_mistake', 'id'=>$d->contract->id), 
										'Correct Mistake', 
										array( 'id'=>'correct-mistake-contract-btn', 'class'=>'deter-btn')
									  ).'
							'.$r->link( 'SupportContract', 
										array( 'action'=>'edit', 'id'=>$d->contract->id), 
										'Update Contract', 
										array( 'id'=>'update-contract-btn', 'class'=>'standard-btn')
									  ).'
							'.$r->link( 'SupportContract', 
										array('action'=>'cancel', 'id'=>$d->contract->id),
										'Cancel Contract', 
										array('id'=>'cancel-contract-btn','class'=>'standard-btn')
									  ).'
						</div>
					';

					$r->view( 'supportcontractEditForm', $d->contract);
    
    $hour_table 		= $r->view( 'hourTable', 		$d->contract->getHours( ));



	return array(
		'title' => $d->	contract->getName(),
		'controls' => $contract_finder,
		'body' 	=> 	$contract_info
					.$hidden_forms
					.$hour_table
		);
}
