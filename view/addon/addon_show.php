<?php
function addonShow($d){
	$r = getRenderer( );

    $title = $d->support_contract->getName();

	$contract_info = '	<div class="detail-list float-left"> 
	 						'.$r->view( 'supportcontractInfo', $d->support_contract).'
						</div>';

    $addon_edit_form = '	<div id="addon-edit-container">
    				   		'.$r->view( 
								  	'addonEditForm', 
    				   			  	$d->addon, 
								  	array('class'=>'clear-left')
    				   			  	).'
    				   	</div>';

	$hidden_forms = $r->view('jsHideable',array(
						'New Add On'	=> $r->view(
												'addonNewForm', 
												$d->new_addon, 
												array('support_contract_id'=>$d->support_contract->id)
											   ),
    				   	'Edit Add On' => $r->view( 
											  	'addonEditForm', 
    				   						  	$d->addon
    				   			  			   )
					), 
					array( 'open_by_default' => array( 'Edit Add On' ) )
					);


    $addon_table = $r->view('addonTable', $d->support_contract->getAddOns(), array('title'=>'AddOns for '.$d->support_contract->getName()));


    return array(   'title' 	=> $title,
                    'body' 		=> 	$contract_info
                    				.$hidden_forms
                    				.$addon_table
    								);
}
    /*
    $r =& getRenderer();
    $addon_finder= $r->view( 'jumpSelect',       $d->addon);
 
    $addon_info = '
                        <div class="detail-list float-left"> 
                            '.$r->view( 'addonInfo', $d->addon).'
                        </div>
                    ';
    


    return array(
        'title' => $d->addon->getName(),
        'controls' => $addon_finder,
        'body'  =>  $addon_info
        );
     */
