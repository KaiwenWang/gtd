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
	isset($o['class']) ? $o['class'] .= ' clear-left' : $o['class'] = 'clear-left';
    $attr = $r->attr($o);
    $html = '';
	if( $o['title']) $html .= '<h3 class="basic-table-header">'.$o['title'].'</h3>';
	$html .= '<div class="quicksearch"><form><input type="text" class="qs-input" name="qs-input" /></form></div>';
	if( isset( $o['search'] ) && $o['search']) $html .= '<div class="basic-table-search">'.$o['search'].'</div>';
    $html .= '<table class="basic-table tablesorter" cellspacing="0" cellpadding="0">';
	$html .= '<thead>';
    $html .= '<tr>';
	foreach ($table['headers'] as $header){
	    $html .= '<th>'.$header.'</th>';
	}
    $html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
    foreach($table['rows'] as $row){
        $html .= '<tr>';
		foreach($row as $cell){
        	$html .= '<td>'.$cell.'</td>';
		}
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';

    return "<div $attr >
				<div class='basic-table-container'>
    				$html
    			</div>
    		</div>";
   
}
?>
