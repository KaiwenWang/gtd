<?php

function staffIndex($d) {
  $r = getRenderer();

  $html = $r->view('staffTable', $d->staff);
  return array(
    'title' => 'Listing All Staff',
    'controls' => '',
    'body' => $html
  );
}

?>
