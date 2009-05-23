<?php
class TestController extends PageController {
    var $_class_name = 'TestController';
    
    function PageController() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r = getRenderer();
        $finder = new Staff();
        $staff = $finder->find(array('first_name'=>$get['first_name']));
        foreach($staff as $s){
        	$name = $s->getName();	
        }
        $finder = new Project();
        $projects = $finder->find( array( 'staff_id'=>$s->id));
        #$projects = Project::getArray(array( 'staff_id'=>$s->id));
        $html = $r->view('testView', $projects, array('id'=>'test'));
        
        return $r->template('template/test_template.html',
        					array(
        					'name'=>$name,
        					'body'=>$html
        					));
    }
}
?>
