<?php
function hourSearch( $hours, $o = array()){
    $r = new Render;
    $start_date = isset($_GET['hour_search']['start_date']) ? $_GET['hour_search']['start_date'] : '';
    $end_date = isset($_GET['hour_search']['end_date']) ? $_GET['hour_search']['end_date'] : '';
    $html = '<form method="get" action="'.$_SERVER['PHP_SELF'] . '">' 
          . '<div class="search-input">'
          . '<label for="hour_search_start">Start Date</label>'
          . '<input type="text" name="hour_search[start_date]" id="hour_search_start" value="'. $start_date .'" >'
          . '</div>'
          . '<div class="search-input">'
          . '<label for="hour_search_end">End Date</label>'
          . '<input type="text" name="hour_search[end_date]" id="hour_search_end" value="'. $end_date .'" >'
          . '</div>'
          . '<div class="search-input">'
          . '<input type="submit" value="search">'
          . '</div>';

    foreach($_GET as $key => $value ) {
        if($key == 'hour_search' ) continue;
        $html .= "<input type='hidden' value='$value' name='$key'>";
    }

    $html .= '</form>'
          . '<script type="text/javascript">'
          . '$( function() { $("#hour_search_start, #hour_search_end").datepicker( { dateFormat: "yy-mm-dd" } ); } );'
          . '</script>';
    return $html;
}
