<?php
function hourSearch( $hours, $o = array()){
    $r = getRenderer();

    $start_date = isset($o['hour_search']['start_date']) ? $o['hour_search']['start_date'] : '';
    $end_date 	= isset($o['hour_search']['end_date']) ? $o['hour_search']['end_date'] : '';
    $company_id = isset($o['company']) ? $o['company'] : '';
    $staff_name = isset($o['staff']) ? $o['staff'] : '';
	unset($o['hour_search']);
	
	$search_form = new Form( array_merge(
								array(	'method'=>'get',
										'controller'=>'Hour',
										'action'=>'search',
										'ajax_target_id'=>'hour_table',
										'auto_submit'=>array('company','hour_search[start_date]','hour_search[end_date]','staff' )
									),
								$o
							));

    $search_form->content = '
		<div class="search-input">
			'.$r->classSelect( 'Company', 
								array('name'=>'company',
										'id'=>'hour_search_company_id',
										'title'=>'Client',
										'selected_value'=>$company_id
									)
								).'
		</div>

        <div class="search-input">
        	<label for="hour_search_start">Start Date</label>
			'.$r->input( 'date', array(	'name'=>'hour_search[start_date]',
										'value'=>$start_date,
										'id'=>'hour_search_start'
										)).'
        </div>
        <div class="search-input">
          	<label for="hour_search_end">End Date</label>
			'.$r->input( 'date', array(	'name'=>'hour_search[end_date]',
										'value'=>$end_date,
										'id'=>'hour_search_end'
										)).'
		</div>
		'.$r->classSelect( 'Staff', 
								array('name'=>'staff_id',
										'id'=>'hour_search_staff_id',
										'title'=>'Staff',
										'selected_value'=>$staff_name
									)
								).'

       	';

	$hours_table = $r->view('hourTable',
							$hours,
							array( 'search' => $search_form->html )
							);

	return ' <div id="'.$o['ajax_target_id'].'" class="hour-search clear-left">
				'.$hours_table.'
			</div>';
}
