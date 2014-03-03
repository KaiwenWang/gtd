<?php

function clientuserIndex($d) {
  $r = getRenderer();

  $clientuser_new = $r->view('jsHideable', array('Create New Client User' => $r->view('clientuserNewForm', $d->new_clientuser)));

  $clientuser_table = $r->view('clientuserTable', $d->clientusers);

  return array(
    'title' => 'Client Users',
    'body' => $clientuser_new.$clientuser_table  
  );
}

?>
