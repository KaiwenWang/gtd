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
        $staff = new Staff($get['staff_id']);

        $name = 'hello ,'.$staff->getName();

		$html .= $r->objectSelect( $staff, array('name'=>'staff_id'));
		$html .= $r->submit();
		$html = $r->form( 'get', 'TestController', $html);
#		$html .= $r->field( $hour, 'description');
		
        #$html = $r->view('hoursList', $hours, array('id'=>'test', 'class'=>'boo', 'name'=>'hoo'));
        
		$r->msg('good','I am a good message');
		$r->msg('bad','I am a bad message');
		
        return $r->template('template/standard_inside.html',
        					array(
        					'title'=>$name,
        					'body'=>$html
        					));
    }
    function post( $post){
    	
    }
}
?>
