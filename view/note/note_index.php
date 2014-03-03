<?php

function noteIndex($d) {
  $r = getRenderer();
  
  return array(
    'title' => 'Listing All Notes',
    'body' => $r->view('noteNewForm', $d->note) . $r->view('noteTable', $d->notes, array('id' => 'Note'))
  );
}

?>
