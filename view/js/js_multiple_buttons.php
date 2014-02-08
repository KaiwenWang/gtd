<?php

function jsMultipleButtons($items, $options) {
  isset($options['open_by_default'])
    ? $open_by_default = array_flip($options['open_by_default'])
    : $open_by_default = array();

  $multiple_buttons = '';
  $target_html = '';
  $id = 0;

  foreach($items as $header => $item) {
    array_key_exists($header, $open_by_default)
      ? $style = ''
      : $style = 'display: none;';
    $multiple_buttons.= '
      <a data-id="' . $id . '" class="multiple-buttons-btn btn btn-' . $id . '"> 
      <span class="title">' . $header . '</span>
      </a>
      ';
    $target_html .= ' 
      <div data-id="' . $id . '" class="multiple-buttons-target" style="' . $style . '">
      ' . $item . '
      </div>
      ';    
    $id++;
  }

  return   '
    <div class="js-multiple-buttons">
    ' . $multiple_buttons . '
    <div class="multiple-buttons-targets">
    ' . $target_html . '
    </div>
    </div>
    ';
}

?>
