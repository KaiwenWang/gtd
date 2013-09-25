<?php
function hourIndex($d){
  $r =& getRenderer();
  $new_hour_forms = $r->view('jsHideable', array(
    'Log Project Hour' => $r->view( 'projectHourLoggerForm', 
    $d->new_hour),
    'Log Support Hour' => $r->view( 'supporthourNewForm', 
    $d->new_support_hour)
  ) 
);



  $hour_table_html = $r->view('hourSearch', $d->hours, array('ajax_target_id'=>'hour-search-1'));

  return  array(
    'title'=>'Listing All Hours',
    'controls'=>'',
    'body'=>
    $new_hour_forms
    . $hour_table_html
  );
}
?>
