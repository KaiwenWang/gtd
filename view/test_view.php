<?php

function testView($data, $o = array()) {
  $id = 'id="' . $o['id'] . '" ';
  $html = '';
  foreach($data as $p){
    $html .= '<li>' . $p->getName() . '</li>';
  }
  return '<ul ' . $id . '>' . $html . '</ul>';
}

?>
