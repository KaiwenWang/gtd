<?php
function companyLineItems($d){

	$support_line_items = $d['company']->calculateSupportLineItems($d['months']);
	$charge_line_items = $d['company']->calculateChargeLineItems($d['months']);
	$project_line_items = $d['company']->calculateProjectLineItems($d['months']);
	//bail('<pre>'.print_r($project_line_items, true).'</pre>');
	$monthly_history = '';
	foreach($d['months'] as $active_month){
		$monthly_history .= '<h2>'.$active_month.'</h2>';
		$monthly_history .= '<table cellpadding="3" cellspacing="0" width="100%" style="margin: 15px 0;">';
		//if(!isset($support_line_items[$active_month])) $support_line_items[$active_month] = 0;
		if(!isset($charge_line_items[$active_month])) $charge_line_items[$active_month] = 0;
		foreach($support_line_items as $month => $support_line_item){
			if($month == $active_month) {
				$monthly_history .= '<tr><td>Monthly Support: '.$support_line_item['name'].'</td>';
				$monthly_history .= '<td></td>';
				$monthly_history .= '<td><strong>'.$support_line_item['hosting'].'</strong><td></tr>';
				$monthly_history .= '<tr><td>Support Hours: '.$support_line_item['name'].'</td>';
				$monthly_history .= '<td>('.$support_line_item['support_hours'].' included, ';
				$monthly_history .= ' '.$support_line_item['support_hours_used'].' used)</td>';
				$monthly_history .= '<td><strong>'.$support_line_item['support_cost'].'</strong><td></tr>';

			}
		}
		foreach($charge_line_items[$active_month] as $charge_line_item){
			// $monthly_history .= draw line item display
			$monthly_history .= '<tr><td>Charge: '.$charge_line_item['name'].'</td>';
			$monthly_history .= '<td>'.$charge_line_item['date'].'</td>';
			$monthly_history .= '<td><strong>'.$charge_line_item['amount'].'</strong></td></tr>';
		}
		foreach($project_line_items as $month => $project_line_item){
			// $monthly_history .= draw line item display
			if($month == $active_month) {
				$monthly_history .= '<tr><td>Project: '.$project_line_item['name'].'</td>';
				$monthly_history .= '<td>'.$project_line_item['project_hours'].' at '.$project_line_item['project_hours_rate'].'</td>';
				$monthly_history .= '<td><strong>'.$project_line_item['project_total'].'</strong><td></tr>';
			}
		}
	};

	$monthly_history .= '</table>';
	return $monthly_history;
}
