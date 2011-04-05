<?php
function companyLineItems($d){

	$support_line_items = $d['company']->calculateSupportLineItems($d['months']);
	$charge_line_items = $d['company']->calculateChargeLineItems($d['months']);
	$project_line_items = $d['company']->calculateProjectLineItems($d['months']);
	//bail('<pre>'.print_r($project_line_items, true).'</pre>');
	$monthly_history = '';
	foreach($d['months'] as $active_month){
		$monthly_history .= '<h3>'.$active_month.'</h3>';
		$monthly_history .= '<table cellpadding="3" cellspacing="0" width="80%" style="margin: 5px 0; font-size: 11px; border: 1px solid grey; ">';
		//if(!isset($support_line_items[$active_month])) $support_line_items[$active_month] = 0;
		if(!isset($charge_line_items[$active_month])) $charge_line_items[$active_month] = 0;
		foreach($support_line_items[$active_month] as $support_line_item){
  		$monthly_history .= '<tr><td>Monthly Support: '.$support_line_item['name'].'</td>';
  		$monthly_history .= '<td></td>';
  		$monthly_history .= '<td align="right"><strong>&#36;'.number_format($support_line_item['hosting'],2).'</strong><td></tr>';
  		$monthly_history .= '<tr><td>Support Hours: '.$support_line_item['name'].'</td>';
  		$monthly_history .= '<td>('.$support_line_item['support_hours'].' included, ';
  		$monthly_history .= ' '.$support_line_item['support_hours_used'].' used)</td>';
  		$monthly_history .= '<td align="right"><strong>&#36;'.number_format($support_line_item['support_cost'], 2).'</strong><td></tr>';
		}
		foreach($charge_line_items[$active_month] as $charge_line_item){
			// $monthly_history .= draw line item display
			$monthly_history .= '<tr><td>Charge: '.$charge_line_item['name'].'</td>';
			$monthly_history .= '<td>'.$charge_line_item['date'].'</td>';
			$monthly_history .= '<td align="right"><strong>&#36;'.number_format($charge_line_item['amount'],2).'</strong></td></tr>';
		}
		foreach($project_line_items[$active_month] as $project_line_item){
			// $monthly_history .= draw line item display
			if(!$project_line_item['project_hours']) continue;
			$monthly_history .= '<tr><td>Project: '.$project_line_item['name'].'</td>';
			$monthly_history .= '<td>'.$project_line_item['project_hours'].' at '.$project_line_item['project_hours_rate'].'</td>';
			$monthly_history .= '<td align="right"><strong>&#36;'.number_format($project_line_item['project_total'], 2).'</strong><td></tr>';
		}
	  $monthly_history .= '</table>';
	};

	return $monthly_history;
}