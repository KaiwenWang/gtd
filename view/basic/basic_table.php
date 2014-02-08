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

function basicTable($table, $o = array()) {
  $r = getRenderer();
  if(empty($o['class'])) $o['class'] = ' clear-left';

  $attr = $r->attr($o);

  $html = '';

  // TITLE	
  if($o['title']) $html .= '<h3 class="basic-table-header">'.$o['title'].'</h3>';

  // SEARCH
  if(isset($o['search']) && $o['search']) $html .= '<div class="basic-table-search">'.$o['search'].'</div>';

  if(isset($o['pager']) && $o['pager'] && (count($table['rows']) > ENTRIES_PER_PAGE)) {
    $html .= '
      <div id="pager" class="tablesorter-pager">
      <form>
      <input type="button" value="&laquo;" class="first btn"/>
      <input type="button" value="&lt;" class="prev btn"/>
      <input type="text" class="pagedisplay"/>
      <input type="button" value="&gt;" class="next btn"/>
      <input type="button" value="&raquo;" class="last btn"/>
      <select class="pagesize">
      <option value="' . ceil(ENTRIES_PER_PAGE) . '">' . ceil(ENTRIES_PER_PAGE) . ' per page</option>
      <option value="' . ceil(ENTRIES_PER_PAGE * 2.5) . '">' . ceil(ENTRIES_PER_PAGE * 2.5) . ' per page</option>
      <option value="' . ceil(ENTRIES_PER_PAGE * 4) . '">' . ceil(ENTRIES_PER_PAGE * 4) . ' per page</option>
      <option value="9999999999">All</option>
      </select>
      </form>
      </div>';
  }

  // CREATE TABLE START
  $html .= '
    <center><table class="tablesorter table table-bordered table-striped table-condensed" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
    ';

  // CREATE TABLE HEADERS
  foreach ($table['headers'] as $header) {
    $html .= '<th>'.$header.'</th>';
  }

  $html .= '
    </tr>
    </thead>
    <tbody>
    ';

  // CREATE TABLE ROWS
  foreach($table['rows'] as $row) {
    $html .= '<tr>';
    foreach($row as $cell) {
      $html .= '
        <td>
        ' . $cell . '
        </td>
        ';
    }
    $html .= '</tr>';
  }

  // CREATE TABLE CLOSE
  $html .= '</tbody>';
  $html .= '</table>';
  $html .= '</center>';

  // RETURN DISPLAY
  return "<div $attr >
    <div class='basic-table-container'>
    $html
    </div>
    </div>";
}

?>
