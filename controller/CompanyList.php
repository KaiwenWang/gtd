<?php
class CompanyList extends PageController {
    var $_class_name = 'CompanyList';

    function CompanyList() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r = getRenderer();
        $finder = new Company();
        $companies = $finder->find(array("sort"=>"custom8,Company") );

        $html = $r->view('companyTable', $companies, array('id'=>'company'));
          
        return $r->template('template/test_template.html',
                            array(
                            'name'=>$name,
                            'body'=>$html
                            ));
    }        
}
?>
