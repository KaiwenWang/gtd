<?php
function supporthourShow($d){
	$r = getRenderer( );

    $title = $d->support_contract->getName();

	$contract_info = '	<div class="detail-list float-left"> 
	 						'.$r->view( 'supportcontractInfo', $d->support_contract).'
						</div>';

    $hour_edit_form = '	<div id="hour-edit-container">
    				   		'.$r->view( 
								  	'hourEditForm', 
    				   			  	$d->hour, 
								  	array('class'=>'clear-left')
    				   			  	).'
    				   	</div>';

	$hidden_forms = $r->view('jsHideable',array(
						'Create New SupportContract'=> $r->view(	
													 	 'supportcontractNewForm', 
														 $d->new_support_contract
														),
						'Log Hours'	=> $r->view(
												'hourNewForm', 
												$d->new_hour, 
												array('support_contract_id'=>$d->support_contract->id)
											   ),
    				   	'Edit Hour' => $r->view( 
											  	'hourEditForm', 
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
