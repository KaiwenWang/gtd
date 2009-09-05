<?php
function companyIndex($d){
        $r =& getRenderer();

        $html = $r->view('companyTable', $d->companies, array('id'=>'company'));
          
        return 		array(
                        'title'=>'Listing All Companies',
                        'controls'=>'',
                        'body'=>$html
                    	);
}
?>