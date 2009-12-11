<?php
function hourIndex($d){
        $r =& getRenderer();
        
        $hour_table_html = $r->view('hourTable', $d->companies, array('id'=>'company'));

        return 	array(
                        'title'=>'Listing All Hours',
                        'controls'=>'',
                        'body'=>
                        $hour_table_html
                    	);
}
?>
