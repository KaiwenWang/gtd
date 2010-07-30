<?php
function companyKneecaps($d){
        $r =& getRenderer();
        
        $company_table_html = $r->view('companyKneecapsTable', $d->companies, array('id'=>'company','search_company'=>$d->search_company));

        return 	array(
                        'title'=>'Listing All Clients for Kicking',
                        'controls'=>'',
                        'body'=>
                        $company_table_html
                    	);
}
?>
