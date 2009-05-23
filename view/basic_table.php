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
function basicTable( $data, $o = array()){
    $id = 'id="'.$o['id'].'" ';
    $html = '<table>';
    $html .= '<tr>';
	foreach ($data['headers'] as $header){
	    $html .= '<th>'.$header.'</th>';
	}
    $html .= '</tr>';
    foreach($data['rows'] as $row){
        $html .= '<tr>';
		foreach($row as $cell){
        	$html .= '<td>'.$cell.'</td>';
		}
        $html .= '</tr>';
    }
    $html .= '</table>';

    return "<div $id>$html</div>";
   
}
?>
