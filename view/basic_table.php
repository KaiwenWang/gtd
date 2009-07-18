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
    $r =& getRenderer();
    $attr = $r->attr($o);
    $html = '';
	if( $o['title']) $html .= '<h3 class="basic-table-header">'.$o['title'].'</h3>';
    $html .= '<table class="basic-table" cellspacing="0" cellpadding="0">';
    $html .= '<tr>';
	foreach ($table['headers'] as $header){
	    $html .= '<th>'.$header.'</th>';
	}
    $html .= '</tr>';
    foreach($table['rows'] as $row){
        $html .= '<tr>';
		foreach($row as $cell){
        	$html .= '<td>'.$cell.'</td>';
		}
        $html .= '</tr>';
    }
    $html .= '</table>';

    return "<div $attr >$html</div>";
   
}
?>
