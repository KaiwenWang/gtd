<?php
class ProjectList extends PageController {
    var $_class_name = 'ProjectList';

    function ProjectList() {
        $this->__construct();
    }
    function __construct(){
        parent::__construct();
    }
    function get( $get = array()){
        $r =& getRenderer();

		$search_criteria = array();
		$search_criteria['sort'] = 'custom17,custom4';#status,launch_date

		if ( $get['staff']){
			$search_criteria['staff_id'] = $get['staff'];
		}
        if ( $get['status']){
            $search_criteria['status'] = $get['status'];
        }
		$finder = new Staff();
		$staff = $finder->find(array('sort'=>'first_name'));
		$staff_html = $r->view('basicModelSelectBox', $staff, array('name'=>'staff'));
		
		$finder = new Project();
        $projects = $finder->find( $search_criteria); 
        $project_html = $r->view('projectTable', $projects, array('id'=>'project'));

        $html = $staff_html.'<br><br>'.$project_html;

        return $r->template('template/test_template.html',
                            array(
                            'name'=>$name,
                            'body'=>$html
                            ));
    }        
}
?>
