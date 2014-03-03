<?php

function clientuserEdit($d) {
  $r = getRenderer();
  $clientuser_show = $r->view('clientuserEditForm', $d->clientuser);
  return array(
    'title' => 'Client User: '.$d->clientuser->getName(),
    'body' => $clientuser_show
  );
}

?>
