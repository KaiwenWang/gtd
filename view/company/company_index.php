  <?php
function companyIndex($d){
        $r =& getRenderer();
        
        $company_new_html = $r->view( 'jsHideable', 
        								array(
        									'Create New Client' => $r->view('companyNewForm', $d->new_company)
        									)
        							);
        							
        $company_table_html = $r->view('companyTable', $d->companies, array('id'=>'company','search_company'=>$d->search_company));

        return 	array(
                        'title'=>'Listing All Clients',
                        'controls'=>'',
                        'body'=>
                        $company_new_html
                        .$company_table_html
                    	);
}
?>
