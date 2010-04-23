<?php
function supporthourShow($d){
	$r = getRenderer( );

    $title = $d->support_contract->getName();

	$contract_info = '	<div class="detail-list float-left"> 
	 						'.$r->view( 'supportcontractInfo', $d->support_contract).'
						</div>';

	$hidden_forms = $r->view('jsHideable',array(
						'Log Hours'	=> $r->view(
												'supporthourNewForm', 
												$d->new_hour, 
												array('support_contract_id'=>$d->support_contract->id)
											   ),
    				   	'Edit Hour' => $r->view( 
											  	'supporthourEditForm', 
    				   						  	$d->hour 
    				   			  			   )
					), 
					array( 'open_by_default' => array( 'Edit Hour' ) )
					);


    $hour_table = $r->view('supporthourTable', $d->support_contract->getHours(), array('title'=>'Hours for '.$d->support_contract->getName()));


    return array(   'title' 	=> $title,
                    'body' 		=> 	$contract_info
                    				.$hidden_forms
                    				.$hour_table
    								);
}
