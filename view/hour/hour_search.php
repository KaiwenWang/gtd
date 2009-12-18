<?php
function hourSearch( $hours, $o = array()){
    $r = getRenderer();

    $start_date = isset($o['hour_search']['start_date']) ? $o['hour_search']['start_date'] : '';
    $end_date 	= isset($o['hour_search']['end_date']) ? $o['hour_search']['end_date'] : '';
	unset($o['hour_search']);

	
	$search_form = new Form( array_merge(
								array(	'method'=>'get',
										'controller'=>'Hour',
										'action'=>'search'),
								$o
							));

    $search_form->content = '
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
        <div class="search-input">
			'.$search_form->submitBtn.'
		</div>
		';

	if($hours){
		$hours_table = $r->view('hourTable',
								$hours,
								array( 'search' => $search_form->html )
								);
	}else{
		$hours_table = '<h3>No hours matched your search</h3>'
						.$search_form->html;
	} 

	return '<div id="'.$o['ajax_target_id'].'" class="hour-search clear-left">
				'.$hours_table.'
			</div>';
}
