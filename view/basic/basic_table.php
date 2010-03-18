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
	if( empty($o['class']) ) $o['class'] = ' clear-left';

    $attr = $r->attr($o);

    $html = '';

// TITLE	
	if( $o['title']) $html .= '<h3 class="basic-table-header">'.$o['title'].'</h3>';

// QUICKSEARCH
	$html .= '
				<div class="quicksearch">
					<form>
						<input type="text" class="qs-input" name="qs-input" />
					</form>
				</div>
			';
// SEARCH
	if( isset( $o['search'] ) && $o['search']) $html .= '<div class="basic-table-search">'.$o['search'].'</div>';


// CREATE TABLE START
    $html .= '
			<table class="basic-table tablesorter" cellspacing="0" cellpadding="0">
				<thead>
    				<tr>
			';

// CREATE TABLE HEADERS
	foreach ($table['headers'] as $header){
	    $html .= '<th>'.$header.'</th>';
	}

    $html .= '
					</tr>
				</thead>
			<tbody>
			';

// CREATE TABLE ROWS
    foreach($table['rows'] as $row){
        $html .= '<tr>';
		foreach($row as $cell){
        	$html .= '
						<td>
							'.$cell.'
						</td>
						';
		}
        $html .= '</tr>';
    }

// CREATE TABLE CLOSE
    $html .= '</tbody>';
    $html .= '</table>';


// RETURN DISPLAY
    return "<div $attr >
				<div class='basic-table-container'>
    				$html
    			</div>
    		</div>";
   
}
?>
