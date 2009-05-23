<?php
class SupportContractList extends PageController {
    var $_class_name = 'SupportContractList';

    function SupportContractList() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r = getRenderer();
        $finder = new SupportContract();
        $companies = $finder->find(array("sort"=>"custom8,Company") ); #status, company_id

        $html = $r->view('supportContractTable', $companies, array('id'=>'support_contract'));
          
        return $r->template('template/test_template.html',
                            array(
                            'name'=>$name,
                            'body'=>$html
                            ));
    }        
}
?>
