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
        
		trigger_error('id:'.$s->id);
   		$projects = getMany( 'Hour', array('staff_id'=>$s->id));
#   		$projects = getMany( 'Project');
#       $finder = new Project();
#       $projects = $finder->find(array('staff_id'=>$s->id)); #status, company_id
        $html = 'boo'.$r->view('hoursList', $projects, array('id'=>'test'));

        return $r->template('template/test_template.html',
        					array(
        					'name'=>$name,
        					'body'=>$html
        					));
    }
}
?>
