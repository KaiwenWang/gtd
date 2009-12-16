<?php
function hourIndex($d){
        $r =& getRenderer();
        $new_hour_forms = $r->view('jsHideable', array(
                    'Create New Project Hour' => $r->view( 'hourNewForm', 
                                                      $d->new_hour),
                    'Create New Support Hour' => $r->view( 'supporthourNewForm', 
                                                      $d->new_support_hour)
                        ) 
  						);


        
        $hour_table_html = $r->view('hourTable', $d->hours, array('id'=>'hour'));

        return  array(
                        'title'=>'Listing All Hours',
                        'controls'=>'',
                        'body'=>
                        $new_hour_forms
                        . $hour_table_html
                        );
}
?>
