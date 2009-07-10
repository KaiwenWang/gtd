<?php
/**
@package view
*/
/**
	companyTable
	
	data (array):
	['headers'] array of column headers
	['rows'] array of rows, each row is an array of data
	
*/
function basicTable( $table, $o = array()){
    $id = 'id="'.$o['id'].'" ';
    $html = '<table  width="80%" cellspacing="1" cellpadding="1">';
    $html .= '<tr>';
	foreach ($table['headers'] as $header){
	    $html .= '<th>'.$header.'</th>';
	}
    $html .= '</tr>';
    foreach($table['rows'] as $row){
        $html .= '<tr bgcolor="#d5d5d5" onmouseout="this.bgColor=\'#D5D5D5\';" onmouseover="this.bgColor=\'#FFE567\';" bordercolor="#333333">';
		foreach($row as $cell){
        	$html .= '<td>'.$cell.'</td>';
		}
        $html .= '</tr>';
    }
    $html .= '</table>';

    return "<div $id>$html</div>";
   
}
?>
