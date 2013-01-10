<?php
function companyLineItemsPlain($d){

	$support_line_items = $d['company']->calculateSupportLineItems($d['months']);
	$charge_line_items = $d['company']->calculateChargeLineItems($d['months']);
	$project_line_items = $d['company']->calculateProjectLineItems($d['months']);
	$monthly_history = "\n\nCharge Details: \n\n";
	foreach($d['months'] as $active_month){
		$monthly_history .= "$active_month \n";
		if(!isset($charge_line_items[$active_month])) $charge_line_items[$active_month] = 0;
		foreach($support_line_items[$active_month] as $support_line_item){
  		$monthly_history .= "Monthly Hosting: ".$support_line_item["name"]." - ";
  		$monthly_history .= number_format($support_line_item["hosting"],2)."\n";
  		$monthly_history .= "Support Hours: ".$support_line_item["name"]." (";
  		$monthly_history .= $support_line_item["support_hours"];
  		$monthly_history .= " ".$support_line_item["support_hours_used"]." used) - ";
  		$monthly_history .= number_format($support_line_item['support_cost'], 2) ."\n";
		}
		foreach($charge_line_items[$active_month] as $charge_line_item){
			$monthly_history .= "Charge: ".$charge_line_item["name"]." ";
			$monthly_history .= $charge_line_item["date"]." - ";
			$monthly_history .= number_format($charge_line_item["amount"],2)."\n";
		}
		foreach($project_line_items[$active_month] as $project_line_item){
			if(!$project_line_item['project_hours']) continue;
			$monthly_history .= "Project: ".$project_line_item["name"]." (";
			$monthly_history .= $project_line_item["project_hours"]." at ".$project_line_item["project_hours_rate"] .") - ";
			$monthly_history .= number_format($project_line_item["project_total"], 2)."\n";
		}
		$monthly_history .= "\n";
	};

	return $monthly_history;
}
