<?php
class ProjectList extends PageController {
    var $_class_name = 'ProjectList';

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
		$staff_form_content = $r->classSelect( 'Staff',
												array('name'=>'staff', 'selected_value'=>$get['staff']),
												array('sort'=>'first_name'));
		$staff_form_content	.= $r->submit();
		$staff_form = $r->form( 'get', 'ProjectList', $staff_form_content);

        $projects = getMany( 'Project', $search_criteria); 
        $project_table = $r->view('projectTable', $projects, array('id'=>'project'));

        $html = $staff_form.'<br><br>'.$project_table;

        return $r->template('template/test_template.html',
                            array(
                            'name'=>$name,
                            'body'=>$html
                            ));
    }
}
?>
