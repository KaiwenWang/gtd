<?php
function graphOverview($d){
  return json_encode(Array('dates' => $d->hours, 'start_date' => $d->start_date, 'end_date' => $d->end_date));
}
?>
